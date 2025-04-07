<?php

namespace App\Services;

use App\Models\User;
use SimpleXMLElement;

class XmlService
{
    public function __construct(
        private User $user,
        private int $batchNumber,
    ) {
    }

    public function create($recipients)
    {
        $xml = $this->createXmlBase($recipients->count());

        dd($xml);
    }

    private function createXmlBase(int $count): SimpleXMLElement
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Mensagem></Mensagem>');

        $idMessage = $xml->addChild('idMensagem');
        $idMessage->addChild('nmServico', 'SolicitaAR');
        $idMessage->addChild('nuVersao', '1.0');
        $idMessage->addChild('deServico', 'Solicitacao de ARs para cumprimento');
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
        $procCompliance->addChild('cdUnidadePostagem', $this->user->unit->posting_unit);
        $procCompliance->addChild('qtAR', (string) $count);

        return $xml;
    }
}
