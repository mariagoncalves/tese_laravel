<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(LanguageTableSeeder::class);
        $this->call(PropUnitTypeTableSeeder::class);
        $this->call(PropUnitTypeNameTableSeeder::class);
        $this->call(ProcessTypeTableSeeder::class);
        $this->call(ProcessTypeNameTableSeeder::class);
        $this->call(CustomFormTableSeeder::class);
        $this->call(CustomFormNameTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(ActorTableSeeder::class);
        $this->call(RoleHasActorTableSeeder::class);
        $this->call(RoleNameTableSeeder::class);
        $this->call(ActorNameTableSeeder::class);
        $this->call(RoleHasUserTableSeeder::class);
        $this->call(ProcessTableSeeder::class);
        $this->call(ProcessNameTableSeeder::class);
        $this->call(TStateTableSeeder::class);
        $this->call(TStateNameTableSeeder::class);
        $this->call(TransactionTypeTableSeeder::class);
        $this->call(TransactionTypeNameTableSeeder::class);
        $this->call(EntTypeTableSeeder::class);
        $this->call(EntTypeNameTableSeeder::class);
        $this->call(EntityTableSeeder::class);
        $this->call(EntityNameTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RelTypeTableSeeder::class);
        $this->call(RelTypeNameTableSeeder::class);
        $this->call(RelationTableSeeder::class);
        $this->call(RelationNameTableSeeder::class);
        $this->call(TransactionTableSeeder::class);
        $this->call(TransactionStateTableSeeder::class);
        $this->call(TransactionAckTableSeeder::class);
        $this->call(ActorIniciatesTTableSeeder::class);
        $this->call(PropertyTableSeeder::class);
        $this->call(PropertyNameTableSeeder::class);
        $this->call(ValueTableSeeder::class);
        $this->call(ValueNameTableSeeder::class);
        $this->call(PropAllowedValueTableSeeder::class);
        $this->call(PropAllowedValueNameTableSeeder::class);
        $this->call(CustomFormHasPropTableSeeder::class);
        $this->call(CausalLinkTableSeeder::class);
        $this->call(WaitingLinkTableSeeder::class);
    }
}
