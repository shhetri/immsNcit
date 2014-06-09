<?php
/**
 * @file ShiftTableSeeder.php
 * @brief Add the default data in 'shifts' table
 * @author Sumit Chhetri
 * @date 6/9/14
 * @bug No known bugs
 */
class ShiftTableSeeder extends Seeder{

    public function run()
    {
        Eloquent::unguard();

        Shift::create([
                'shift' =>  'Morning'
            ]);

        Shift::create([
                'shift' =>  'Day'
            ]);
    }

} 