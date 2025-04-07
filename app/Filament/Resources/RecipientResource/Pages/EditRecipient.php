<?php

namespace App\Filament\Resources\RecipientResource\Pages;

use App\Enums\FinishTypeEnum;
use App\Filament\Resources\RecipientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecipient extends EditRecord
{
    protected static string $resource = RecipientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id']     = user()->id;
        $data['postal_code'] = str_replace('-', '', $data['postal_code']);

        if ($data['file_pages'] <= 5) {
            $data['finish_type'] = FinishTypeEnum::SELFENVELOPMENT;
        } else {
            $data['finish_type'] = FinishTypeEnum::INSERTION;
        }

        return $data;
    }
}
