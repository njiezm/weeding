<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\EtapeCeremonie;
use App\Models\Lecture;
use App\Models\Chant;
use App\Models\Priere;
use App\Models\Remerciement;
use App\Models\MemoryCard;

class CeremonieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MemoryCard::truncate();
        Priere::truncate();
        Chant::truncate();
        Lecture::truncate();
        EtapeCeremonie::truncate();
        Remerciement::truncate();

        // Réactiver les contraintes
        DB::statement('SET session_replication_role = DEFAULT;');

        // === 1. Création du message de remerciements ===
        Remerciement::create([
            'titre' => 'Remerciements',
            'contenu' => <<<'EOT'
Nous rendons grâce pour toutes les personnes que Dieu a placées sur notre chemin.
À travers une présence, une écoute, un conseil, une prière ou un geste, chacun a contribué, à sa manière, à nous accompagner dans ce chemin de vie et de foi.
Parfois, nous savions demander. Parfois, nous ne savions pas comment. Mais nous avons toujours trouvé une main tendue, un regard bienveillant, une parole juste.
Merci d'avoir cru en nous, même lorsque rien ne semblait gagné d'avance.
Aujourd'hui, nous témoignons que l'amour, l'acceptation et la compréhension, soutenus par la foi, ont été plus forts.
Merci d'être ici, de prier avec nous et de partager ce moment de grâce.
EOT,
            'signatures' => 'Maëva & Gilles',
        ]);

        // === 2. Création des étapes de la cérémonie ===
        $etape1 = EtapeCeremonie::create(['ordre' => 1, 'titre' => 'OUVERTURE DE LA CÉLÉBRATION', 'icone' => 'fa-solid fa-door-open', 'termine' => true]);
        $etape2 = EtapeCeremonie::create(['ordre' => 2, 'titre' => 'DIEU NOUS PARLE', 'icone' => 'fa-solid fa-book-bible', 'en_cours' => true]); // Étape en cours pour l'exemple
        $etape3 = EtapeCeremonie::create(['ordre' => 3, 'titre' => 'DIEU NOUS UNIT', 'icone' => 'fa-solid fa-hands-praying']);
        $etape4 = EtapeCeremonie::create(['ordre' => 4, 'titre' => 'TOUTE UNE VIE POUR S\'AIMER', 'icone' => 'fa-solid fa-heart']);
        $etape5 = EtapeCeremonie::create(['ordre' => 5, 'titre' => 'REMERCIEMENTS', 'icone' => 'fa-solid fa-champagne-glasses']);


        // === 3. Création des lectures, chants et prières associés ===

        // --- Étape 1: OUVERTURE ---
        $etape1->chants()->create([
            'titre' => 'Que tes œuvres sont belles',
            'auteur' => 'Traditionnel',
            'paroles' => <<<'EOT'
Que tes œuvres sont belles,
Que tes œuvres sont grandes !
Seigneur, Seigneur, tu nous combles de joie.
Que tes œuvres sont belles,
Que tes œuvres sont grandes !
Seigneur, Seigneur, tu nous combles de joie.

1
C'est toi, le Dieu qui nous as faits, qui nous as pétris de la terre !
Tout homme est une histoire sacrée, l'homme est à l'image de Dieu !
Ton amour nous a façonnés, tirés du ventre de la terre !
Tout homme est une histoire sacrée, l'homme est à l'image de Dieu !
Tu as mis en nous ton Esprit : nous tenons debout sur la terre !
Tout homme est une histoire sacrée, l'homme est à l'image de Dieu !
EOT,
        ]);

        // --- Étape 2: DIEU NOUS PARLE ---
        $etape2->lectures()->create([
            'titre' => 'Lecture du Livre de la Genèse',
            'reference' => 'Genèse 1, 26-28.31a',
            'contenu' => <<<'EOT'
Au commencement, Dieu dit: « Faisons l'homme à notre image, selon notre ressemblance. Qu'il soit le maître des poissons de la mer, des oiseaux du ciel, des bestiaux, de toutes les bêtes sauvages et de toutes les bestioles qui vont et viennent sur la terre »
Dieu créa l'homme à son image, à l'image de Dieu il créa, il les créa homme et femme.
Dieu les bénit et leur dit : « Soyez féconds et multipliez-vous, remplissez la terre et soumettez-la. Soyez les maîtres des poissons de la mer, des oiseaux du ciel, et de tous les animaux qui vont et viennent sur la terre »
Et Dieu vit tout ce qu'il avait fait : c'était très bon.
EOT,
        ]);
        
        $etape2->lectures()->create([
            'titre' => 'Évangile de Jésus Christ selon Saint Jean',
            'reference' => 'Jean 17, 20-26',
            'contenu' => <<<'EOT'
À l'heure où Jésus passait de ce monde à son père, il leva les yeux au ciel et pria ainsi : « Père, je ne prie pas seulement pour ceux qui sont là, mais encore pour ceux qui accueilleront leur parole et croiront en moi : Que tous, ils soient un, comme toi, Père, tu es en moi, et moi en toi. Qu'ils soient un en nous, eux aussi, pour que le monde croie que tu m'as envoyé. Et moi, je leur ai donné la gloire que tu m'as donnée, pour qu'ils soient un comme nous sommes un : moi en eux, et toi en moi. Que leur unité soit parfaite ; ainsi, le monde saura que tu m'as envoyé et que tu les as aimés comme tu m'as aimé. »
EOT,
        ]);

        $etape2->chants()->create([
            'titre' => 'Psaumes de la création',
            'auteur' => 'A. Dumont',
            'paroles' => <<<'EOT'
1er couplet
Par les cieux devant toi, splendeur et majesté
Par l'infiniment grand, l'infiniment petit
Et par le firmament, ton manteau étoilé,
Et par frère soleil, je veux crier :
Refrain
Mon Dieu, tu es grand, tu es beau,
Dieu vivant, Dieu très haut, tu es le Dieu d'amour ;
Mon Dieu, tu es grand, tu es beau,
Dieu vivant, Dieu très haut,
Dieu présent, en toute création.
5e couplet
Par cette main tendue qui invite à la danse
Par ce baiser jailli d'un élan d'espérance
Par ce regard d'amour qui relève et réchauffe
Par le pain et le vin, je veux crier :
EOT,
        ]);

        // --- Étape 3: DIEU NOUS UNIT ---
        $etape3->chants()->create([
            'titre' => 'Viens, Esprit du Dieu vivant',
            'auteur' => 'H. Le Bars',
            'paroles' => <<<'EOT'
Viens esprit du dieu vivant, esprit d'amour
Lumière Bienheureuse nous t'attendons
Viens esprit de vérité, souffle de feu
Embrase-nous, purifie-nous et guéris-nous

Viens Esprit Saint, Onction céleste
Remplis nos cœurs de ta présence
Révèle nous l'amour du Père
Agis en nous transforme nous
EOT,
        ]);
        
        $etape3->prieres()->create([
            'titre' => 'Prière des époux',
            'contenu' => <<<'EOT'
Seigneur notre Dieu, tu nous as conduits jusqu'à ce jour de bonheur : nous te disons notre reconnaissance. Tu nous as confiés l'un à l'autre : maintenant, ensemble, nous te confions notre amour.
Nous te demandons, Seigneur, de nous tenir unis, de nous garder dans ta paix. Protège notre mariage. [Donne-nous d'accueillir des enfants.] Ouvre nos coeurs aux autres. Donne-nous d'être fidèles tout au long de notre vie. Accueille-nous un jour au Royaume de ton amour, où nous pourrons te louer dans le bonheur et dans la paix. Amen.
EOT,
        ]);
        
        // --- Étape 4: TOUTE UNE VIE POUR S'AIMER ---
        $etape4->chants()->create([
            'titre' => 'Je te promets',
            'auteur' => 'D. Diu',
            'paroles' => <<<'EOT'
Devant nos familles devant Dieu je prends ta main et je dis oui Je te vois là Tu me souris Aujourd'hui je t'épouse Pour la vie
Je te promets fidélité Je te promets tendresse Je te promets d'être là Dans la joie et la peine Je te promets mon amour Je te promets ma force Je te promets un foyer Rempli de bonheur
Cette alliance au doigt Symbole d'union Brillera comme Mon amour pour toi Tu es mon choix Tu es ma voie Aujourd'hui je m'engage Auprès de toi
EOT,
        ]);

        $etape4->prieres()->create([
            'titre' => 'Notre Père',
            'contenu' => <<<'EOT'
Notre Père qui est aux cieux,
Que Ton Nom soit sanctifié,
Que Ton règne vienne,
Que Ta volonté soit faite
Sur la terre comme au ciel.
Donne-nous aujourd'hui Notre pain de ce jour.
Pardonne-nous nos offenses Comme nous pardonnons aussi à ceux Qui nous ont offensés.
Et ne nous laisse pas entrer en tentation, Mais délivre-nous du mal. Amen.
EOT,
        ]);
        
        // --- Étape 5: REMERCIEMENTS ---
        $etape5->chants()->create([
            'titre' => 'Que ma bouche chante tes louanges',
            'auteur' => 'J.P. Lécot',
            'paroles' => <<<'EOT'
De toi, Seigneur, nous attendons la vie,
Que ma bouche chante ta louange.
Tu es pour nous un rempart, un appui,
Que ma bouche chante ta louange.
La joie du cœur vient de toi ô Seigneur,
Que ma bouche chante ta louange.
Notre confiance est dans ton nom très saint !
Que ma bouche chante ta louange.

Sois loué Seigneur, pour ta grandeur,
Sois loué pour tous tes bienfaits.
Gloire à toi Seigneur, tu es vainqueur,
Ton amour inonde nos cœurs.
Que ma bouche chante ta louange.
EOT,
        ]);
        
        $etape5->chants()->create([
            'titre' => 'Evenou Shalom',
            'auteur' => 'Traditionnel Hébreu',
            'paroles' => <<<'EOT'
Evenou shalom alerhem !
Evenou shalom alerhem !
Evenou shalom alerhem !
Evenou shalom, shalom, shalom alerhem !

1 - Nous vous annonçons la paix. (Ter)
Nous vous annonçons la paix, la paix, la paix de Jésus !
2 - Nous vous annonçons la joie...
3 - Nous vous annonçons l'amour...
EOT,
        ]);

        // === 4. Création des paires de cartes pour le jeu Memory ===
        // NOTE: Vous devrez ajouter les images manuellement dans le dossier storage/app/public/memory-cards/
        // et les nommer comme indiqué ci-dessous (ex: maeva.jpg, gilles.jpg, etc.)
        
        $memoryCards = [
            // Paire 1
            ['titre' => 'Gilles', 'pair_id' => 'pair-1', 'image_path' => 'memory-cards/gilles.jpg'],
            ['titre' => 'Gilles', 'pair_id' => 'pair-1', 'image_path' => 'memory-cards/gilles.jpg'],
            // Paire 2
            ['titre' => 'Les Alliances', 'pair_id' => 'pair-2', 'image_path' => 'memory-cards/anneaux.jpg'],
            ['titre' => 'Les Alliances', 'pair_id' => 'pair-2', 'image_path' => 'memory-cards/anneaux.jpg'],
            // Paire 3
            ['titre' => 'Le Baiser', 'pair_id' => 'pair-3', 'image_path' => 'memory-cards/baiser.jpg'],
            ['titre' => 'Le Baiser', 'pair_id' => 'pair-3', 'image_path' => 'memory-cards/baiser.jpg'],
            // Paire 4
            ['titre' => 'Le Livret', 'pair_id' => 'pair-4', 'image_path' => 'memory-cards/livret.jpg'],
            ['titre' => 'Le Livret', 'pair_id' => 'pair-4', 'image_path' => 'memory-cards/livret.jpg'],
            // Paire 5
            ['titre' => 'Maëva', 'pair_id' => 'pair-5', 'image_path' => 'memory-cards/maeva.jpg'],
            ['titre' => 'Maëva', 'pair_id' => 'pair-5', 'image_path' => 'memory-cards/maeva.jpg'],

            // Paire 6
            ['titre' => 'Eglise', 'pair_id' => 'pair-6', 'image_path' => 'memory-cards/eglise.jpg'],
            ['titre' => 'Eglise', 'pair_id' => 'pair-6', 'image_path' => 'memory-cards/eglise.jpg'],

            // Paire 7
            ['titre' => 'Mairie', 'pair_id' => 'pair-7', 'image_path' => 'memory-cards/mairie.jpg'],
            ['titre' => 'Mairie', 'pair_id' => 'pair-7', 'image_path' => 'memory-cards/mairie.jpg'],

            // Paire 8
            ['titre' => 'Photo', 'pair_id' => 'pair-8', 'image_path' => 'memory-cards/photo.jpg'],
            ['titre' => 'Photo', 'pair_id' => 'pair-8', 'image_path' => 'memory-cards/photo.jpg'],
        ];

        foreach ($memoryCards as $cardData) {
            MemoryCard::create([
                'titre' => $cardData['titre'],
                'description' => "Carte pour le jeu Memory de Maëva et Gilles.",
                'pair_id' => $cardData['pair_id'],
                'image_path' => $cardData['image_path'],
                'actif' => true,
            ]);
        }
    }
}