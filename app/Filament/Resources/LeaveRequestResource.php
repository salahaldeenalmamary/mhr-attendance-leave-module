<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Filament\Resources\LeaveRequestResource\RelationManagers;
use App\Models\LeaveRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Employee Details')
                    ->schema([
                        Select::make('employee_id')
                            ->relationship('employee', 'name')
                            ->required(),

                        Select::make('leave_type_id')
                            ->relationship('leaveType', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Section::make('Leave Duration')
                    ->schema([
                        DatePicker::make('start_date')
                            ->required(),

                        DatePicker::make('end_date')
                            ->required(),

                        TextInput::make('requested_days')
                            ->required()
                            ->numeric(),
                    ]),

                Section::make('Reason & Status')
                    ->schema([
                        Textarea::make('reason')
                            ->columnSpanFull(),

                     
                             Forms\Components\Select::make('status')
                    ->options([
                         'Pending', 'Approved', 'Rejected', 'Cancelled'
                    ])->default('Pending')
                    ->label('Status')
                    ->required(),

                          
                    ]),

                Section::make('Approver Information')
                    ->schema([
                        Select::make('approver_id')
                            ->relationship(
                                name: 'approver',
                                titleAttribute: 'name',

                            )
                            ->searchable()
                            ->preload()
                            ->placeholder('Select an Approver'),

                        Textarea::make('approver_comments')
                            ->columnSpanFull(),
                    ]),

                Section::make('Timestamps')
                    ->schema([
                        DateTimePicker::make('requested_at')
                            ->required(),

                        DateTimePicker::make('actioned_at'),
                    ]),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('leaveType.name')
                    ->label('Leave Type')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('requested_days')
                    ->label('Requested Days')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Approver')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('requested_at')
                    ->label('Requested At')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('actioned_at')
                    ->label('Actioned At')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters here if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
