<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use App\Models\Branch;
use App\Models\CashShift;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 7 Sucursales Verificadas en Mérida, Yucatán
        $branch1 = Branch::create([
            'name' => 'Big Apple Francisco de Montejo',
            'zone' => 'Francisco de Montejo',
            'category_type' => 'Hamburguesería',
            'rating' => 4.3,
            'address' => 'Calle 61 #195, Francisco de Montejo, Mérida, Yuc.',
            'city' => 'Mérida',
            'phone' => '+52 999 354 1087',
            'whatsapp_number' => '529993541087',
            'schedule' => 'Lun - Jue: 11:00 – 22:30 | Vie - Dom: 11:00 – 23:30',
            'is_active' => true,
        ]);

        $branch2 = Branch::create([
            'name' => 'Big Apple Dorada',
            'zone' => 'Paseo de las Fuentes / Villas Zona Dorada',
            'category_type' => 'Restaurante Americano',
            'rating' => 3.9,
            'address' => 'Calle 47 #553 x 102, Paseo de las Fuentes / Villas Zona Dorada, Mérida, Yuc.',
            'city' => 'Mérida',
            'phone' => '+52 999 135 1212',
            'whatsapp_number' => '529991351212',
            'schedule' => 'Lun - Jue: 11:00 – 22:30 | Vie - Dom: 11:00 – 23:30',
            'is_active' => true,
        ]);

        $branch3 = Branch::create([
            'name' => 'Big Apple Caucel',
            'zone' => 'Ciudad Caucel',
            'category_type' => 'Restaurante',
            'rating' => 3.9,
            'address' => 'Calle 70 #750 por 93 (o por 97), Cd. Caucel, Mérida, Yuc.',
            'city' => 'Mérida',
            'phone' => '+52 999 492 4327',
            'whatsapp_number' => '529994924327',
            'schedule' => 'Lun - Jue: 11:00 – 22:30 | Vie - Dom: 11:00 – 23:30',
            'is_active' => true,
        ]);

        $branch4 = Branch::create([
            'name' => 'Big Apple Américas Plaza Royal',
            'zone' => 'Dzityá / Las Américas (Plaza Royal)',
            'category_type' => 'Restaurante Americano',
            'rating' => 4.7,
            'address' => 'Calle 69 N553-L16, Dzityá / Las Américas (Plaza Royal), Mérida, Yuc.',
            'city' => 'Mérida',
            'phone' => '+52 999 215 1522',
            'whatsapp_number' => '529992151522',
            'schedule' => 'Lun - Jue: 11:00 – 23:00 | Vie - Dom: 11:00 – 23:30',
            'is_active' => true,
        ]);

        $branch5 = Branch::create([
            'name' => 'Big Apple Girasoles de Opichen',
            'zone' => 'Fracc. Girasoles de Opichén',
            'category_type' => 'Restaurante',
            'rating' => 4.3,
            'address' => 'Calle 81 Diag. #1192, Fracc. Girasoles de Opichén, Mérida, Yuc.',
            'city' => 'Mérida',
            'phone' => '+52 999 148 1508',
            'whatsapp_number' => '529991481508',
            'schedule' => 'Lun - Jue: 11:00 – 22:30 | Vie - Dom: 11:00 – 23:30',
            'is_active' => true,
        ]);

        $branch6 = Branch::create([
            'name' => 'Big Apple Sur (Serapio Rendón)',
            'zone' => 'Serapio Rendón II',
            'category_type' => 'Hamburguesería',
            'rating' => 3.9,
            'address' => 'Calle 131 #143 x 44 y 46, Serapio Rendón II, Mérida, Yuc.',
            'city' => 'Mérida',
            'phone' => '+52 999 449 7831',
            'whatsapp_number' => '529994497831',
            'schedule' => 'Lun - Jue: 11:00 – 22:30 | Vie - Dom: 11:00 – 23:30',
            'is_active' => true,
        ]);

        $branch7 = Branch::create([
            'name' => 'Big Apple Xtabay Plaza Mura',
            'zone' => 'Leandro Valle / Macroplaza (Plaza Mura)',
            'category_type' => 'Restaurante Americano',
            'rating' => 4.1,
            'address' => 'Calle 39 Local 6 (Plaza Mura), Leandro Valle / Macroplaza, Mérida, Yuc.',
            'city' => 'Mérida',
            'phone' => '+52 999 149 5947',
            'whatsapp_number' => '529991495947',
            'schedule' => 'Lun - Jue: 11:00 – 22:30 | Vie - Dom: 11:00 – 23:30',
            'is_active' => true,
        ]);

        // 1. Super Administrador General
        User::create([
            'email' => 'admin@bigapplediner.com',
            'name' => 'Super Admin Big Apple',
            'username' => 'admin',
            'password' => bcrypt('123'),
            'role' => 'superadmin',
            'branch_id' => null,
        ]);

        // 2. Gerentes de cada Sucursal
        $managers = [
            ['email' => 'montejo@bigapplediner.com', 'name' => 'Gerente Fco. de Montejo', 'username' => 'gerente_montejo', 'branch_id' => $branch1->id],
            ['email' => 'dorada@bigapplediner.com', 'name' => 'Gerente Plaza Dorada', 'username' => 'gerente_dorada', 'branch_id' => $branch2->id],
            ['email' => 'caucel@bigapplediner.com', 'name' => 'Gerente Caucel', 'username' => 'gerente_caucel', 'branch_id' => $branch3->id],
            ['email' => 'royal@bigapplediner.com', 'name' => 'Gerente Américas Plaza Royal', 'username' => 'gerente_royal', 'branch_id' => $branch4->id],
            ['email' => 'opichen@bigapplediner.com', 'name' => 'Gerente Opichén', 'username' => 'gerente_opichen', 'branch_id' => $branch5->id],
            ['email' => 'sur@bigapplediner.com', 'name' => 'Gerente Sur Serapio', 'username' => 'gerente_sur', 'branch_id' => $branch6->id],
            ['email' => 'xtabay@bigapplediner.com', 'name' => 'Gerente Xtabay Macroplaza', 'username' => 'gerente_xtabay', 'branch_id' => $branch7->id],
        ];

        foreach ($managers as $m) {
            User::create([
                'email' => $m['email'],
                'name' => $m['name'],
                'username' => $m['username'],
                'password' => bcrypt('123'),
                'role' => 'branch_manager',
                'branch_id' => $m['branch_id'],
            ]);
        }

        // Sample Empleados Sucursal Centro
        $emp1 = \App\Models\Employee::create([
            'branch_id' => $branch1->id,
            'name' => 'Carlos Mendoza',
            'position' => 'Cocinero Principal',
            'phone' => '9991112233',
            'salary_monthly' => 12000.00,
        ]);
        $emp2 = \App\Models\Employee::create([
            'branch_id' => $branch1->id,
            'name' => 'Valeria Canché',
            'position' => 'Cajera Turno Matutino',
            'phone' => '9992223344',
            'salary_monthly' => 9500.00,
        ]);
        $emp3 = \App\Models\Employee::create([
            'branch_id' => $branch1->id,
            'name' => 'Rodrigo Pech',
            'position' => 'Repartidor Express',
            'phone' => '9993334455',
            'salary_monthly' => 8500.00,
        ]);

        // Sample Empleados Sucursal Montejo
        $emp4 = \App\Models\Employee::create([
            'branch_id' => $branch2->id,
            'name' => 'Mateo Herrera',
            'position' => 'Chef de Parrilla & Smash',
            'phone' => '9994445566',
            'salary_monthly' => 13000.00,
        ]);
        $emp5 = \App\Models\Employee::create([
            'branch_id' => $branch2->id,
            'name' => 'Sofía Lizama',
            'position' => 'Cajera & Atención',
            'phone' => '9995556677',
            'salary_monthly' => 9500.00,
        ]);

        // Sample Asistencia del día de hoy
        \App\Models\AttendanceRecord::create([
            'employee_id' => $emp1->id,
            'branch_id' => $branch1->id,
            'date' => now()->toDateString(),
            'clock_in' => '11:45:00',
            'status' => 'on_time',
            'notes' => 'Entrada puntual a cocina',
        ]);
        \App\Models\AttendanceRecord::create([
            'employee_id' => $emp2->id,
            'branch_id' => $branch1->id,
            'date' => now()->toDateString(),
            'clock_in' => '11:58:00',
            'status' => 'on_time',
            'notes' => 'Apertura de turno en caja',
        ]);
        \App\Models\AttendanceRecord::create([
            'employee_id' => $emp4->id,
            'branch_id' => $branch2->id,
            'date' => now()->toDateString(),
            'clock_in' => '12:40:00',
            'status' => 'on_time',
            'notes' => 'Preparación de parrilla',
        ]);

        // Sample Insumos para cada una de las 7 sucursales
        $baseSupplies = [
            ['name' => 'Carne Molida Artesanal Especial', 'category' => 'Carnes & Pollo', 'unit' => 'kg', 'current_stock' => 30.0, 'min_stock' => 10.0, 'unit_cost' => 140.00],
            ['name' => 'Pechuga de Pollo Fresca Crujiente', 'category' => 'Carnes & Pollo', 'unit' => 'kg', 'current_stock' => 20.0, 'min_stock' => 8.0, 'unit_cost' => 110.00],
            ['name' => 'Pan Brioche Artesanal Sellado', 'category' => 'Panadería', 'unit' => 'pzas', 'current_stock' => 90, 'min_stock' => 30, 'unit_cost' => 8.50],
            ['name' => 'Queso Cheddar Americano Líquido', 'category' => 'Quesos & Lácteos', 'unit' => 'litros', 'current_stock' => 8.0, 'min_stock' => 4.0, 'unit_cost' => 135.00],
            ['name' => 'Papas Cajún Naturales', 'category' => 'Abarrotes', 'unit' => 'kg', 'current_stock' => 50.0, 'min_stock' => 15.0, 'unit_cost' => 32.00],
            ['name' => 'Salsa Jack Daniel\'s Secreta', 'category' => 'Salsas', 'unit' => 'litros', 'current_stock' => 5.0, 'min_stock' => 3.0, 'unit_cost' => 180.00],
            ['name' => 'Empaques Biodegradables Big Apple', 'category' => 'Empaques', 'unit' => 'pzas', 'current_stock' => 200, 'min_stock' => 50, 'unit_cost' => 4.20],
        ];

        $allBranches = [$branch1, $branch2, $branch3, $branch4, $branch5, $branch6, $branch7];

        foreach ($allBranches as $index => $b) {
            foreach ($baseSupplies as $sup) {
                Supply::create(array_merge($sup, ['branch_id' => $b->id]));
            }

            // Sample Turno de caja abierto
            CashShift::create([
                'branch_id' => $b->id,
                'user_id' => $index + 2, // Gerente
                'opened_at' => now()->setTime(11, 00),
                'opening_amount' => 1500.00,
                'cash_sales' => rand(1800, 4500),
                'card_sales' => rand(1200, 3200),
                'transfer_sales' => rand(400, 1500),
                'cash_expenses' => rand(100, 450),
                'expected_cash' => 2800.00,
                'status' => 'open',
                'notes' => 'Turno activo sin incidencias',
            ]);

            // Sample Gasto
            Expense::create([
                'branch_id' => $b->id,
                'user_id' => $index + 2,
                'category' => 'Insumos / Perecederos',
                'description' => 'Hielo purificado y verduras frescas del día',
                'amount' => rand(180, 420),
                'payment_method' => 'cash',
                'receipt_number' => 'FAC-' . rand(1000, 9999),
                'date' => now()->toDateString(),
            ]);
        }


        // Categorías
        $catEntradas = Category::create([
            'name' => 'Entradas & Snacks',
            'slug' => 'entradas-snacks',
            'description' => 'Papas artesanales, alitas, boneless y snacks para abrir el apetito diner.',
            'icon' => 'fries',
            'sort_order' => 1,
        ]);

        $catBurgers = Category::create([
            'name' => 'Hamburguesas',
            'slug' => 'hamburguesas',
            'description' => 'Hamburguesas artesanales con vegetales frescos. Incluyen papas cajún.',
            'icon' => 'burger',
            'sort_order' => 2,
        ]);

        $catChicken = Category::create([
            'name' => 'Chicken Sandwich',
            'slug' => 'chicken-sandwich',
            'description' => 'Sandwiches de pollo crujiente o pechuga bañados en tu salsa favorita.',
            'icon' => 'drumstick',
            'sort_order' => 3,
        ]);

        $catSmash = Category::create([
            'name' => 'Smash Burgers',
            'slug' => 'smash-burgers',
            'description' => 'Carne aplastada en la plancha al punto perfecto de doraditos y costra.',
            'icon' => 'fire',
            'sort_order' => 4,
        ]);

        $catPasta = Category::create([
            'name' => 'Fettuccines & Arma tu Pasta',
            'slug' => 'fettuccines-pasta',
            'description' => 'Pastas preparadas al momento con salsas artesanales e ingredientes a tu gusto.',
            'icon' => 'utensils',
            'sort_order' => 5,
        ]);

        $catCombos = Category::create([
            'name' => 'Paquetes & Combos',
            'slug' => 'paquetes-combos',
            'description' => 'Combinaciones de alto valor ideal para compartir en pareja o familia.',
            'icon' => 'box',
            'sort_order' => 6,
        ]);

        $catCrepas = Category::create([
            'name' => 'Crepas Dulces & Saladas',
            'slug' => 'crepas',
            'description' => 'Crepas recién hechas a la plancha con tus ingredientes favoritos.',
            'icon' => 'cookie',
            'sort_order' => 7,
        ]);

        $catBebidas = Category::create([
            'name' => 'Bebidas, Frappes & Postres',
            'slug' => 'bebidas-postres',
            'description' => 'Frappes cremosos, limonadas de fresa preparadas y refrescos.',
            'icon' => 'glass-water',
            'sort_order' => 8,
        ]);

        // --- 1. ENTRADAS & SNACKS ---
        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Papas Fritas Naturales Cajún',
            'slug' => 'papas-fritas-cajun',
            'description' => 'Rebanadas muy finas de papa natural sazonadas con el toque especial cajún.',
            'price' => 39.00,
            'badge' => 'Cajún',
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Papas a la Francesa',
            'slug' => 'papas-a-la-francesa',
            'description' => 'Orden de papas a la francesa doraditas y crujientes.',
            'price' => 59.00,
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Papas Gajo con Queso',
            'slug' => 'papas-gajo-queso',
            'description' => 'Papas crujientes en forma de gajo acompañadas de delicioso queso Cheddar líquido.',
            'price' => 59.00,
            'badge' => 'Top Snack',
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Papas a la Francesa con Queso',
            'slug' => 'papas-francesa-queso',
            'description' => 'Orden de papas cubiertas de una rica mezcla especial de quesos fundidos.',
            'price' => 69.00,
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Jalapeños Poppers (6 Pzas)',
            'slug' => 'jalapenos-poppers',
            'description' => '6 deliciosos chiles jalapeños empanizados, rellenos de queso crema y tocino, acompañados de salsa BBQ y papas a la francesa.',
            'price' => 99.00,
            'badge' => 'Favorito',
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Dedos de Queso (6 Pzas)',
            'slug' => 'dedos-de-queso',
            'description' => '6 crujientes dedos de queso gouda, acompañados de salsa pomodoro artesanal y papas a la francesa.',
            'price' => 99.00,
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Boneless Jugosos',
            'slug' => 'boneless-jugosos',
            'description' => 'Trozos de pechuga empanizada bañados en la salsa de tu elección. Acompañados de dip.',
            'price' => 109.00,
            'type' => 'portion_selectable',
            'variants' => [
                ['label' => '9 Piezas', 'price' => 109.00],
                ['label' => '14 Piezas', 'price' => 139.00],
                ['label' => '18 Piezas', 'price' => 199.00],
            ],
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Alitas de Pollo',
            'slug' => 'alitas-de-pollo',
            'description' => 'Alitas de pollo doraditas bañadas en la salsa de tu elección (Mango Habanero, Buffalo, Jack Daniel\'s o BBQ).',
            'price' => 129.00,
            'type' => 'portion_selectable',
            'variants' => [
                ['label' => '8 Piezas', 'price' => 129.00],
                ['label' => '12 Piezas', 'price' => 179.00],
                ['label' => '16 Piezas', 'price' => 239.00],
            ],
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Tiras Crispy',
            'slug' => 'tiras-crispy',
            'description' => 'Tiras de pechuga de pollo crujientes bañadas en tu salsa favorita.',
            'price' => 109.00,
            'type' => 'portion_selectable',
            'variants' => [
                ['label' => '4 Piezas', 'price' => 109.00],
                ['label' => '8 Piezas', 'price' => 189.00],
                ['label' => '12 Piezas', 'price' => 279.00],
            ],
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Paque Compartas',
            'slug' => 'paque-compartas',
            'description' => '12 piezas de jugosos boneless acompañados con papas gajo y queso cheddar líquido.',
            'price' => 159.00,
            'badge' => 'Combo Snack',
            'type' => 'standard',
        ]);

        // --- 2. HAMBURGUESAS ---
        $burgers = [
            [
                'name' => 'King Kong Burger',
                'slug' => 'king-kong-burger',
                'description' => 'La única hamburguesa con todos los ingredientes: Champiñones, tocino, chorizo, piña, jamón, mix de quesos y vegetales frescos. Incluye papas cajún.',
                'price' => 129.00,
                'image' => 'images/bigapplenobg/kingkong129.png',
                'badge' => 'Insignia Diner',
            ],
            [
                'name' => 'Big Apple Burger',
                'slug' => 'big-apple-burger',
                'description' => 'Hamburguesa estrella con doble carne artesanal, bañada con aderezo Jack Daniel\'s, doble mezcla de quesos, tocino y vegetales frescos. Incluye papas cajún.',
                'price' => 149.00,
                'image' => 'images/bigapplenobg/bigapple149.png',
                'badge' => 'Especialidad',
            ],
            [
                'name' => 'Bacon Burger',
                'slug' => 'bacon-burger',
                'description' => 'Hamburguesa con tiras de tocino crujiente, mix de quesos y vegetales frescos. Incluye papas cajún.',
                'price' => 95.00,
                'image' => 'images/bigapplenobg/bacon95.png',
            ],
            [
                'name' => 'Hawaiana Burger',
                'slug' => 'hawaiana-burger',
                'description' => 'Hamburguesa con rodaja de piña asada a la plancha, mix de quesos y vegetales frescos. Incluye papas cajún.',
                'price' => 95.00,
                'image' => 'images/bigapplenobg/hawaiana95.png',
            ],
            [
                'name' => 'Chorizo Burger',
                'slug' => 'chorizo-burger',
                'description' => 'Hamburguesa con toque de chorizo regional asado, mix de quesos y vegetales frescos. Incluye papas cajún.',
                'price' => 95.00,
                'image' => 'images/bigapplenobg/chorizo95.png',
            ],
            [
                'name' => 'Mushroom Burger',
                'slug' => 'mushroom-burger',
                'description' => 'Hamburguesa con champiñones salteados a la plancha, mix de quesos y vegetales frescos. Incluye papas cajún.',
                'price' => 95.00,
                'image' => 'images/bigapplenobg/mushroom95.png',
            ],
            [
                'name' => 'Clásica Original Burger',
                'slug' => 'clasica-original-burger',
                'description' => 'Hamburguesa clásica con jugosa carne artesanal, mix de quesos, aderezo especial y vegetales frescos. Incluye papas cajún.',
                'price' => 85.00,
                'image' => 'images/bigapplenobg/clasicaorigina85.png',
            ],
        ];

        foreach ($burgers as $b) {
            Product::create([
                'category_id' => $catBurgers->id,
                'name' => $b['name'],
                'slug' => $b['slug'],
                'description' => $b['description'],
                'price' => $b['price'],
                'image' => $b['image'] ?? null,
                'badge' => $b['badge'] ?? null,
                'type' => 'burger',
            ]);
        }

        // --- 3. CHICKEN SANDWICH ---
        $chickenSandwiches = [
            [
                'name' => 'Crispy Chicken Sandwich',
                'slug' => 'crispy-chicken-sandwich',
                'description' => 'Tiras de pollo crujientes, mix de quesos y vegetales frescos. Pídela bañada en tu salsa favorita.',
                'price' => 95.00,
                'image' => 'images/bigapplenobg/chickencrispy95.png',
            ],
            [
                'name' => 'Boneless Chicken Sandwich',
                'slug' => 'boneless-chicken-sandwich',
                'description' => 'Jugosos boneless de pechuga, mix de quesos y vegetales frescos. Pídela bañada en tu salsa favorita.',
                'price' => 95.00,
                'image' => 'images/bigapplenobg/chickenboneless95.png',
            ],
            [
                'name' => 'Pechuga a la Plancha Sandwich',
                'slug' => 'pechuga-plancha-sandwich',
                'description' => 'Pechuga de pollo a la plancha, mix de quesos y vegetales frescos. Pídela bañada en tu salsa favorita.',
                'price' => 95.00,
                'image' => 'images/bigapplenobg/chickenpenchugalaplancha95.png',
            ],
        ];

        foreach ($chickenSandwiches as $cs) {
            Product::create([
                'category_id' => $catChicken->id,
                'name' => $cs['name'],
                'slug' => $cs['slug'],
                'description' => $cs['description'],
                'price' => $cs['price'],
                'image' => $cs['image'] ?? null,
                'type' => 'chicken_sandwich',
            ]);
        }

        // --- 4. SMASH BURGERS ---
        $smash = [
            [
                'name' => 'Smash Original',
                'slug' => 'smash-original',
                'description' => 'Carne artesanal aplastada a fuego alto con aderezo de la casa, mix de quesos fundidos y pepinillos.',
                'price' => 99.00,
                'image' => 'images/bigapplenobg/smashoriginal99.png',
            ],
            [
                'name' => 'Smash Doble',
                'slug' => 'smash-doble',
                'description' => 'Doble carne artesanal smash con aderezo de la casa, doble mix de quesos fundidos y pepinillos.',
                'price' => 119.00,
                'image' => 'images/bigapplenobg/smashdoble119.png',
                'badge' => 'Doble Carne',
            ],
            [
                'name' => 'Smash Bacon',
                'slug' => 'smash-bacon',
                'description' => 'Doble carne artesanal smash con aderezo de la casa, tocino crujiente, mix de quesos y pepinillos.',
                'price' => 139.00,
                'image' => 'images/bigapplenobg/smashbacon139.png',
            ],
            [
                'name' => 'Smash Mushroom',
                'slug' => 'smash-mushroom',
                'description' => 'Doble carne artesanal smash con aderezo de la casa, champiñones salteados, mix de quesos y pepinillos.',
                'price' => 139.00,
                'image' => 'images/bigapplenobg/smashmushroom139.png',
            ],
        ];

        foreach ($smash as $sm) {
            Product::create([
                'category_id' => $catSmash->id,
                'name' => $sm['name'],
                'slug' => $sm['slug'],
                'description' => $sm['description'],
                'price' => $sm['price'],
                'image' => $sm['image'] ?? null,
                'badge' => $sm['badge'] ?? null,
                'type' => 'standard',
            ]);
        }

        // --- 5. FETTUCCINES & ARMA TU PASTA ---
        Product::create([
            'category_id' => $catPasta->id,
            'name' => 'Fettuccine Clásico',
            'slug' => 'fettuccine-clasico',
            'description' => 'Pasta fettuccine bañada en la salsa de tu elección (Chipotle, Alfredo o Mantequilla) con 1 proteína a elegir (Tiras Crispy, Pollo a la Plancha, Boneless o Champiñones).',
            'price' => 129.00,
            'type' => 'fettuccine',
            'variants' => [
                ['label' => 'Individual', 'price' => 129.00],
                ['label' => 'Pareja', 'price' => 229.00],
            ],
        ]);

        Product::create([
            'category_id' => $catPasta->id,
            'name' => 'Arma tu Pasta (Módulo Interactivo)',
            'slug' => 'arma-tu-pasta',
            'description' => 'Wizard de 4 pasos: Elige tamaño (Individual/Pareja), Salsa (Chipotle, Alfredo, Mantequilla), Proteína y 3 Ingredientes a tu gusto.',
            'price' => 149.00,
            'badge' => 'Personalizable',
            'type' => 'pasta_wizard',
            'variants' => [
                ['label' => 'Individual (Incluye 3 ingredientes)', 'price' => 149.00],
                ['label' => 'Pareja (Porción Doble + 3 ingredientes)', 'price' => 269.00],
            ],
        ]);

        // --- 6. PAQUETES & COMBOS ---
        Product::create([
            'category_id' => $catCombos->id,
            'name' => 'Big Pack (Combo Familiar)',
            'slug' => 'big-pack',
            'description' => '6 boneless, 6 tiras crispy, 6 alitas, 4 jalapeños poppers, 4 dedos de queso, papas gajo, apio y zanahoria. Incluye: Buffalo, queso cheddar, ranch, BBQ y pomodoro.',
            'price' => 329.00,
            'image' => 'images/bigapplenobg/bigpack329.png',
            'badge' => 'Súper Combo',
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catCombos->id,
            'name' => 'Central Pack',
            'slug' => 'central-pack',
            'description' => '6 boneless, 3 tiras crispy, 4 alitas, 2 jalapeños poppers, 2 dedos de queso, papas gajo, apio y zanahoria. Incluye: Buffalo, queso cheddar, ranch, BBQ y pomodoro.',
            'price' => 229.00,
            'image' => 'images/bigapplenobg/centralpack229.png',
            'badge' => 'Para Compartir',
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catCombos->id,
            'name' => 'Paquete Pareja',
            'slug' => 'paquete-pareja',
            'description' => 'Hamburguesa Bacon + Hamburguesa Crispy + 2 Bebidas Naturales (500 ml).',
            'price' => 199.00,
            'image' => 'images/bigapplenobg/paquetepareja199.png',
            'badge' => 'Especial Pareja',
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catCombos->id,
            'name' => 'Paquete Familiar',
            'slug' => 'paquete-familiar',
            'description' => '2 Hamburguesas Clásicas + 2 Hamburguesas Crispy + 1 Coca-Cola 1.35 L + 1 Bebida Natural 1 L.',
            'price' => 349.00,
            'image' => 'images/bigapplenobg/paquetefamiliar349.png',
            'badge' => 'Familiar Mega',
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catCombos->id,
            'name' => 'Aderezo Extra',
            'slug' => 'aderezo-extra',
            'description' => 'Porción extra de aderezo a tu elección (Queso Cheddar, Jack Daniel\'s, Buffalo, BBQ, Ranch o Mango Habanero).',
            'price' => 15.00,
            'type' => 'portion_selectable',
        ]);

        // --- 7. CREPAS ---
        Product::create([
            'category_id' => $catCrepas->id,
            'name' => 'Crepa Personalizada',
            'slug' => 'crepa-personalizada',
            'description' => 'Crepa artesanal a la plancha con la combinación de ingredientes que más te guste.',
            'price' => 39.00,
            'badge' => 'Dulce o Salada',
            'type' => 'crepa_wizard',
            'variants' => [
                ['label' => '1 Ingrediente', 'price' => 39.00],
                ['label' => '2 Ingredientes', 'price' => 49.00],
                ['label' => '3 Ingredientes', 'price' => 59.00],
            ],
        ]);

        // --- 8. BEBIDAS, FRAPPES & POSTRES ---
        Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Frappe Helado (500 ml)',
            'slug' => 'frappe-helado',
            'description' => 'Frappe cremoso a elegir entre Moka-Oreo o Nutella-Cajeta. Elige tu tipo de leche (Entera o Deslactosada).',
            'price' => 59.00,
            'badge' => 'Creamy',
            'type' => 'portion_selectable',
        ]);

        Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Café Frío',
            'slug' => 'cafe-frio',
            'description' => 'Café frío preparado de la casa.',
            'price' => 39.00,
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Galleta con Chispas de Chocolate',
            'slug' => 'galleta-chispas',
            'description' => 'Galleta horneada estilo americano con chispas de chocolate.',
            'price' => 20.00,
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Limonada de Fresa Natural (500 ml)',
            'slug' => 'limonada-fresa-500ml',
            'description' => 'Limonada artesanal con pulpa natural de fresa (500 ml). Receta Insignia Diner.',
            'price' => 25.00,
            'badge' => 'Insignia',
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Limonada de Fresa Natural (1 Litro)',
            'slug' => 'limonada-fresa-1l',
            'description' => 'Limonada artesanal con pulpa natural de fresa (1 Litro). Receta Insignia Diner.',
            'price' => 39.00,
            'badge' => 'Receta Casa',
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Té Verde Cítrico Kirkland (500 ml)',
            'slug' => 'te-verde-kirkland',
            'description' => 'Té verde cítrico refrescante Kirkland 500 ml.',
            'price' => 25.00,
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Refresco de Lata (600 ml)',
            'slug' => 'refresco-600ml',
            'description' => 'Refresco embotellado de 600 ml (Coca-Cola original, Coca-Cola sin azúcar, Sprite, Mundet, Fanta).',
            'price' => 39.00,
            'type' => 'standard',
        ]);

        Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Agua Purificada (500 ml)',
            'slug' => 'agua-purificada',
            'description' => 'Botella de agua purificada 500 ml.',
            'price' => 15.00,
            'type' => 'standard',
        ]);
    }
}
