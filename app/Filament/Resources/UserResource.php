<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;
use Filament\Tables\Filters\SelectFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('first_name')
                                    ->label('First Name')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('phone_primary')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\DatePicker::make('hire_date')
                                    ->label('Hire Date'),
                            ]),
                    ]),

                Forms\Components\Section::make('Employment Details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('department_id')
                                    ->label('Department')
                                    ->relationship('department', 'name')
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Select::make('employment_type_id')
                                    ->label('Employment Type')
                                    ->relationship('employmentType', 'name')
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\TextInput::make('job_title')
                                    ->label('Job Title')
                                    ->maxLength(255),

                                Forms\Components\Select::make('manager_id')
                                    ->label('Manager')
                                    ->relationship('manager', 'name')
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\TextInput::make('employment_status')
                                    ->label('Status'),

                                Forms\Components\TextInput::make('employee_code')
                                    ->label('Employee Code')
                                    ->maxLength(50),
                            ]),
                    ]),

                Forms\Components\Section::make('Account & Security')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('email_verified_at')
                                    ->label('Email Verified At'),

                                Forms\Components\TextInput::make('otp')
                                    ->label('OTP')
                                    ->maxLength(255),

                                Forms\Components\DateTimePicker::make('otp_expires_at')
                                    ->label('OTP Expires At'),
                            ]),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->maxLength(255)
                            ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone_primary')->searchable(),
                Tables\Columns\TextColumn::make('hire_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('department.name')->label('Department')->sortable(),
                Tables\Columns\TextColumn::make('employmentType.name')->label('Employment Type')->sortable(),
                Tables\Columns\TextColumn::make('job_title')->searchable(),
                Tables\Columns\TextColumn::make('manager.name')->label('Manager')->sortable(),
                Tables\Columns\TextColumn::make('employment_status'),
                Tables\Columns\TextColumn::make('model_has_roles.name')
                    ->label('Role')
                    ->badge()
                    ->color('info')
                    ->limit(1),

                Tables\Columns\TextColumn::make('otp_expires_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

                SelectFilter::make('role')
                    ->label('Role')
                    ->options(Role::pluck('name', 'name'))
                    ->query(function ($query, array $data) {
                        if (empty($data['value'])) {
                            return $query;
                        }

                        return $query->whereHas('roles', function ($q) use ($data) {
                            $q->where('name', $data['value']);
                        });
                    }),



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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
