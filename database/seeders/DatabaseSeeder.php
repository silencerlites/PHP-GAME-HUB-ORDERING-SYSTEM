<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@gamehub.test'], [
            'name' => 'GameHub Admin', 'password' => 'password', 'role' => 'admin', 'status' => 'active',
        ]);
        User::updateOrCreate(['email' => 'staff@gamehub.test'], [
            'name' => 'GameHub Staff', 'password' => 'password', 'role' => 'staff', 'status' => 'active',
        ]);
        User::updateOrCreate(['email' => 'customer@gamehub.test'], [
            'name' => 'Demo Player', 'password' => 'password', 'role' => 'customer', 'status' => 'active',
        ]);

        $games = [
            ['title'=>'The Legend of Zelda: Breath of the Wild','platform'=>'Nintendo Switch','genre'=>'Adventure','price'=>2495,'stock_quantity'=>12,'description'=>'Open-world fantasy adventure with exploration, puzzles, and action.'],
            ['title'=>'Mario Kart 8 Deluxe','platform'=>'Nintendo Switch','genre'=>'Racing','price'=>2195,'stock_quantity'=>18,'description'=>'Fast local and online kart racing with colorful tracks and characters.'],
            ['title'=>'Super Smash Bros. Ultimate','platform'=>'Nintendo Switch','genre'=>'Fighting','price'=>2395,'stock_quantity'=>10,'description'=>'Platform fighting game with a huge roster of iconic characters.'],
            ['title'=>'Pokemon Legends: Arceus','platform'=>'Nintendo Switch','genre'=>'RPG','price'=>2295,'stock_quantity'=>14,'description'=>'Explore a historic region and complete the first Pokédex.'],
            ['title'=>'God of War: Chains of Olympus','platform'=>'PSP','genre'=>'Action','price'=>795,'stock_quantity'=>8,'description'=>'Portable mythological action adventure for PSP collectors.'],
            ['title'=>'Monster Hunter Freedom Unite','platform'=>'PSP','genre'=>'Action RPG','price'=>895,'stock_quantity'=>9,'description'=>'Classic monster hunting, crafting, and cooperative quests.'],
            ['title'=>'Persona 3 Portable','platform'=>'PSP','genre'=>'JRPG','price'=>995,'stock_quantity'=>6,'description'=>'Story-driven role-playing with social links and dungeon exploration.'],
            ['title'=>'Gran Turismo','platform'=>'PSP','genre'=>'Racing','price'=>745,'stock_quantity'=>11,'description'=>'Portable racing with a large selection of cars and tracks.'],
            ['title'=>'Spider-Man 2','platform'=>'PlayStation 5','genre'=>'Action','price'=>3295,'stock_quantity'=>7,'description'=>'Superhero action and traversal across an open-world city.'],
            ['title'=>'Forza Horizon 5','platform'=>'Xbox Series X|S','genre'=>'Racing','price'=>2895,'stock_quantity'=>5,'description'=>'Open-world festival racing with hundreds of cars.'],
            ['title'=>'Animal Crossing: New Horizons','platform'=>'Nintendo Switch','genre'=>'Simulation','price'=>2195,'stock_quantity'=>13,'description'=>'Build a peaceful island community at your own pace.'],
            ['title'=>'Final Fantasy Tactics: The War of the Lions','platform'=>'PSP','genre'=>'Strategy RPG','price'=>1095,'stock_quantity'=>4,'description'=>'Deep tactical battles with job systems and a classic story.'],
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(['title'=>$game['title'], 'platform'=>$game['platform']], $game + ['status'=>'active']);
        }
    }
}
