<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Affiche le menu de la semaine.
     * Les menus sont ici en dur (statiques) — ils pourront être gérés en BDD dans une évolution future.
     */
    public function index()
    {
        // Numéro de la semaine courante pour afficher la bonne semaine
        $semaine = now()->weekOfYear;

        $jours = [
            'Lundi'    => [
                'entree'   => 'Salade de lentilles au vinaigre',
                'plat'     => 'Poulet rôti, haricots verts',
                'dessert'  => 'Yaourt nature',
                'vegetarien' => false,
            ],
            'Mardi'    => [
                'entree'   => 'Velouté de potimarron',
                'plat'     => 'Quiche lorraine, salade verte',
                'dessert'  => 'Compote de pommes',
                'vegetarien' => true,
            ],
            'Mercredi' => [
                'entree'   => 'Carottes râpées',
                'plat'     => 'Steak haché, purée maison',
                'dessert'  => 'Tarte aux fruits',
                'vegetarien' => false,
            ],
            'Jeudi'    => [
                'entree'   => 'Taboulé maison',
                'plat'     => 'Filet de saumon, riz pilaf',
                'dessert'  => 'Fromage blanc au miel',
                'vegetarien' => false,
            ],
            'Vendredi' => [
                'entree'   => 'Soupe de légumes',
                'plat'     => 'Pizza margherita maison',
                'dessert'  => 'Mousse au chocolat',
                'vegetarien' => true,
            ],
        ];

        // Jour courant en français pour le mettre en évidence
        $joursMap = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi'];
        $jourCourant = $joursMap[now()->dayOfWeekIso] ?? null;

        return view('pages.menu-semaine', compact('jours', 'semaine', 'jourCourant'));
    }
}
