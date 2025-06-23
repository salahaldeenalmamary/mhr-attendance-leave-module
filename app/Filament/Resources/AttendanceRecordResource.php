<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceRecordResource\Pages;
use App\Models\AttendanceRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendanceRecordResource extends Resource
{
    protected static ?string $model = AttendanceRecord::class;

   protected static ?string $navigationIcon = 'heroicon-o-calendar-days';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\DatePicker::make('attendance_date')
                    ->label('Date')
                    ->required(),

                Forms\Components\TimePicker::make('clock_in_time')
                    ->label('Clock In'),

                Forms\Components\TimePicker::make('clock_out_time')
                    ->label('Clock Out'),

                Forms\Components\Select::make('status')
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'leave' => 'Leave',
                        'late' => 'Late',
                    ])
                    ->label('Status')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->columnSpanFull(),

              
                      Forms\Components\Select::make('source')
                    ->options([
                        'Biometric'=> 'Biometric', 
                        'Manual Entry', 'GPS'
                        
                    ])
                    ->label('Status')
                    ->required(),
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

                Tables\Columns\TextColumn::make('attendance_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('clock_in_time')
                    ->label('Clock In'),

                Tables\Columns\TextColumn::make('clock_out_time')
                    ->label('Clock Out'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'present' => 'success',
                        'absent' => 'danger',
                        'leave' => 'warning',
                        'late' => 'gray',
                        default => 'secondary',
                    })
                    ->label('Status'),

                Tables\Columns\TextColumn::make('source')
                    ->label('Source'),

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
                // Optional: Add filters like date range, employee, status
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
            'index' => Pages\ListAttendanceRecords::route('/'),
            'create' => Pages\CreateAttendanceRecord::route('/create'),
            'edit' => Pages\EditAttendanceRecord::route('/{record}/edit'),
        ];
    }
}
