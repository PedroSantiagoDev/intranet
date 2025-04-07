<?php

namespace App\Helpers;

use Smalot\PdfParser\Parser;

class PdfParserHelper
{
    /**
     * @return array<string, int>
     */
    public static function parser(string $filePath): null|array
    {
        if (file_exists($filePath)) {
            $parser = new Parser();
            $pdf    = $parser->parseFile($filePath);

            $size  = filesize($filePath);
            $pages = count($pdf->getPages());

            return [
                'pages' => $pages,
                'size'  => $size,
            ];
        }

        return null;
    }
}
