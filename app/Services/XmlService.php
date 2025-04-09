<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class XmlService
{
    private Filesystem $storage;

    public function __construct(
        private User $user,
        private int $batchNumber
    ) {
        $this->storage = Storage::disk('public');
    }

    /**
     * Creates the XML with the container data and saves it in storage.
     *
     * @param \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipient> $recipients
     * @return string
     */
    public function create(Collection $recipients): string
    {
        $xml = $this->createXmlBase($recipients->count());
        $this->addRecipients($xml, $recipients);

        $path = 'recipient-pdf/xml/' . $this->fileName();
        $this->storage->put($path, $this->formatXml($xml));

        return $path;
    }

    private function createXmlBase(int $count): SimpleXMLElement
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Mensagem></Mensagem>');

        $idMessage = $xml->addChild('idMensagem');
        $idMessage->addChild('nmServico', 'SolicitaAR');
        $idMessage->addChild('nuVersao', '1.0');
        $idMessage->addChild('deServico', '????');
        $idMessage->addChild('seqServico', (string) $this->batchNumber);
        $idMessage->addChild('nmOrigem', $this->user->unit->sender_name);
        $idMessage->addChild('identSpool', 'N');
        $idMessage->addChild('NomeSpool');
        $idMessage->addChild('nmDestino', 'CORREIOS');
        $idMessage->addChild('dtMensagem', date('Ymd'));

        $procCompliance = $xml->addChild('CorpoMensagem')->addChild('procCumprimento');
        $procCompliance->addChild('cdLote', (string) $this->batchNumber);
        $procCompliance->addChild('nuContrato', $this->user->unit->contract_number);
        $procCompliance->addChild('cdAdministrativo', $this->user->unit->administrative_number);
        $procCompliance->addChild('nuCartaoCliente', $this->user->unit->postage_card);
        $procCompliance->addChild('cdUnidadePostagem', $this->user->unit->posting_unit);
        $procCompliance->addChild('qtAR', (string) $count);
        $procCompliance->addChild('arsCumprimento');

        return $xml;
    }

    /**
     * Add the recipient's data to the xml.
     *
     * @param SimpleXMLElement $xml
     * @param \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipient> $recipients
     * @return void
     */
    private function addRecipients(SimpleXMLElement $xml, Collection $recipients): void
    {
        $ars = $xml->xpath('//arsCumprimento')[0];

        foreach ($recipients as $recipient) {
            $ar = $ars->addChild('AR');
            $ar->addChild('deTipoPostagem', 'AR');
            $ar->addChild('IdObjetoCliente', (string) $recipient->id);
            $ar->addChild('qtPagina', (string) $recipient->file_pages);

            $destCompliance = $ar->addChild('destCumprimento');
            $this->addNode($destCompliance, [
                'nmDestinatario'    => $recipient->name,
                'deLogradouroDest'  => $recipient->street,
                'nuEnderecoDest'    => $recipient->number,
                'deComplementoDest' => $recipient->complement,
                'dePontoReferDest'  => '',
                'deBairroDest'      => $recipient->neighborhood,
                'deCidadeDest'      => $recipient->city,
                'cdUFDest'          => $recipient->state,
                'nuCEPDest'         => $recipient->postal_code,
            ]);

            $this->addSender($ar);

            $arqCompliance = $ar->addChild('arqCumprimento');
            $newName       = "e-Carta_{$this->user->unit->matrix_code}_{$this->batchNumber}_{$recipient->id}_1_complementar.pdf";
            $arqCompliance->addChild('nmArquivo', $newName);
            $arqCompliance->addChild('IdComplementar', 'S');

            if ($this->storage->exists($recipient->file_path)) {
                $this->storage->move($recipient->file_path, "recipient-pdf/$newName");
                $recipient->update(['file_path' => $newName]);
            }
        }
    }

    private function addSender(SimpleXMLElement $xml): SimpleXMLElement
    {
        $remCompliance = $xml->addChild('remCumprimento');

        $this->addNode($remCompliance, [
            'nmRemetente'      => $this->user->unit->name,
            'deLogradouroRem'  => $this->user->unit->street,
            'nuEnderecoRem'    => $this->user->unit->number,
            'deComplementoRem' => '',
            'dePontoReferRem'  => '',
            'deBairroRem'      => $this->user->unit->neighborhood,
            'deCidadeRem'      => $this->user->unit->city,
            'cdUFRem'          => $this->user->unit->state,
            'nuCEPRem'         => $this->user->unit->postal_code,
            'nuFoneRem'        => $this->user->unit->phone,
            'deEmailRem'       => $this->user->unit->email,
        ]);

        return $remCompliance;
    }

    /**
     * @param SimpleXMLElement $parent
     * @param array<string, string> $data
     * @return void
     */
    private function addNode(SimpleXMLElement $parent, array $data): void
    {
        foreach ($data as $key => $value) {
            $parent->addChild($key, $value);
        }
    }

    private function formatXml(SimpleXMLElement $xml): string
    {
        $dom               = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;

        return $dom->saveXML();
    }

    private function fileName(): string
    {
        return "e-Carta_{$this->user->unit->matrix_code}_{$this->batchNumber}_servico.xml";
    }
}
