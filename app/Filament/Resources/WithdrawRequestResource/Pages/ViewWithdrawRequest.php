<?php

namespace App\Filament\Resources\WithdrawRequestResource\Pages;

use App\Filament\Resources\WithdrawRequestResource;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;

class ViewWithdrawRequest extends ViewRecord
{
    protected static string $resource = WithdrawRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Change Status')

                ->color($this->record->status== 0 ? 'warning' :( $this->record->status == 1 ? 'success':($this->record->status == 2 ? 'info':'danger')))
            ->label($this->record->status == 0 ? 'Pending' : ($this->record->status == 1 ? 'Accepted' : ($this->record->status == 2 ? 'Paid' : 'Rejected')))
                ->icon($this->record->status == 0 ? 'heroicon-o-exclamation-triangle' : 'heroicon-o-check-circle')

                ->requiresConfirmation()
                ->action(
                    function (array $data): void {

                        $this->record->update($data);
                        $this->refreshFormData([
                            'received_by_user_id',
                            'received_date',
                            'status'
                        ]);
                    }
                )->form([
                   Select::make('status')->options([
                    0 => 'Pending',
                    1 => 'Accepted',
                    2 => 'Paid',
                    3 => 'Rejected',
                ]),
                ]),
            Actions\EditAction::make(),
        ];
    }
}
