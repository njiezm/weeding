<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Ajout de cette ligne
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
        // Utilisation de Schema::disableForeignKeyConstraints() compatible avec PostgreSQL
        Schema::disableForeignKeyConstraints();

        MemoryCard::truncate();
        Priere::truncate();
        Chant::truncate();
        Lecture::truncate();
        EtapeCeremonie::truncate();
        Remerciement::truncate();

        // Réactivation des contraintes
        Schema::enableForeignKeyConstraints();

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

« L'amour prend patience, l'amour rend service… L'amour ne passera jamais. » (1 Co 13, 4-8)
EOT,
            'signatures' => 'Maëva & Gilles',
        ]);

        // === 2. Création des étapes de la cérémonie ===
        $etape1 = EtapeCeremonie::create(['ordre' => 1, 'titre' => 'OUVERTURE DE LA CÉLÉBRATION', 'icone' => 'fa-solid fa-door-open', 'termine' => true]);
        $etape2 = EtapeCeremonie::create(['ordre' => 2, 'titre' => 'DIEU NOUS PARLE', 'icone' => 'fa-solid fa-book-bible', 'en_cours' => true]);
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
            'titre' => 'Psaume 148',
            'reference' => 'Psaume 148',
            'contenu' => <<<'EOT'
Alléluia, louez le Seigneur, alléluia, alléluia !
Louez le Seigneur du haut des cieux,
louez-le dans les hauteurs.
Vous, tous ses anges, louez-le,
louez-le, tous les univers.
Louez-le, soleil et lune,
louez-le, tous les astres de lumière ;
vous, cieux des cieux, louez-le,
et les eaux des hauteurs des cieux.
Les rois de la terre et tous les peuples,
les princes et tous les juges de la terre ;
tous les jeunes gens et jeunes filles,
les vieillards comme les enfants.
Qu'ils louent le nom du Seigneur,
le seul au-dessus de tout nom;
sur le ciel et sur la terre, sa splendeur :
il accroît la vigueur de son peuple.
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
            'titre' => 'Alleluia é',
            'auteur' => 'Traditionnel',
            'paroles' => <<<'EOT'
Alleluia é, Allelluia é é é (bis) Louez le seigneur allelou, alleluia, allelluia é é é
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
            'titre' => 'Dialogue initial',
            'contenu' => <<<'EOT'
Le prêtre : Gilles et Maëva, vous avez écouté la parole de Dieu qui révèle la grandeur de l'amour humain et du mariage. Vous allez vous engager l'un envers l'autre. Est-ce librement et sans contrainte ?
Les futurs époux (séparément) : Oui.
Le prêtre : En vous engageant dans la voie du mariage, vous vous promettez amour mutuel et respect. Est-ce pour toute votre vie ?
Les futurs époux (séparément) : Oui (pour toute notre vie).
Le prêtre : Êtes-vous prêts à accueillir les enfants que Dieu vous donne et à les éduquer selon l'Évangile du Christ et dans la foi de l'Église ?
Les futurs époux (séparément) : Oui.
Le prêtre : Êtes-vous disposés à assumer ensemble votre mission de chrétiens dans le monde et dans l'Église ?
Les futurs époux (ensemble) : Oui.
EOT,
        ]);

        $etape3->prieres()->create([
            'titre' => 'Échange des consentements',
            'contenu' => <<<'EOT'
Gilles : Maëva veux-tu être ma femme ?
Maëva : Oui je le veux.
Et toi, Gilles veux-tu être mon mari ?
Gilles : Oui je le veux. Moi, Gilles je te reçois Maëva comme femme et je serai ton mari Gilles. Je promets de t'aimer fidèlement dans le bonheur et dans les épreuves tout au long de notre vie.
Maëva : Moi, Maëva je te reçois Gilles comme mari et je serai ta femme Maëva. Je promets de t'aimer fidèlement dans le bonheur et dans les épreuves tout au long de notre vie.
Gilles : Maëva reçois cette alliance, signe de mon amour et de ma fidélité. (Au nom du Père, et du Fils, et du Saint-Esprit.)
Maëva : Gilles reçois cette alliance, signe de mon amour et de ma fidélité. (Au nom du Père, et du Fils, et du Saint-Esprit.)
EOT,
        ]);

        $etape3->prieres()->create([
            'titre' => 'Bénédiction nuptiale',
            'contenu' => <<<'EOT'
Père très saint, créateur du monde, toi qui as fait l'homme et la femme à ton image, toi qui as voulu leur union et qui l'as bénie, nous te prions humblement pour Gilles et Maëva qui sont unis aujourd'hui par le sacrement de mariage.
Que ta bénédiction descende en abondance sur eux.
Que la force de l'Esprit Saint les enflamme de ton amour; Qu'ils trouvent le bonheur en se donnant l'un à l'autre ; [Que des enfants viennent embellir leur foyer et que l'Église en soit enrichie.] Dans la joie, qu'ils sachent te remercier; dans la tristesse, qu'ils se tournent vers toi ; que ta présence les aide dans leur travail; qu'ils te trouvent à leur côté dans l'épreuve pour alléger leur fardeau.
Qu'ils participent à la prière de ton Église et témoignent de toi dans le monde.
Enfin, après avoir vécu longtemps heureux, qu'ils parviennent, entourés de leurs amis, dans le Royaume des cieux.
Par Jésus, le Christ, notre Seigneur.
Tous : Amen.
EOT,
        ]);

        $etape3->chants()->create([
            'titre' => 'Comment ne pas te louer',
            'auteur' => 'Traditionnel',
            'paroles' => <<<'EOT'
Comment ne pas te louer-er-er
Comment ne pas te louer-er-er
Comment ne pas te louer-er-er Seigneur Jésus !
Comment ? Comment ?
1.Quand je regarde autour de moi Je vois ta gloire, Seigneur Jésus, je te bénis. Comment ne pas te louer-erer, Seigneur Jésus ! Comment ? Comment ?
2. Quand je regarde autour de moi Je vois mes frères, Seigneur Jésus, merci pour eux. Comment ne pas te louer-er-er, Seigneur Jésus ! Comment ? Comment ?
EOT,
        ]);

        $etape3->prieres()->create([
            'titre' => 'Prière des époux',
            'contenu' => <<<'EOT'
Seigneur notre Dieu, tu nous as conduits jusqu'à ce jour de bonheur : nous te disons notre reconnaissance. Tu nous as confiés l'un à l'autre : maintenant, ensemble, nous te confions notre amour.
Nous te demandons, Seigneur, de nous tenir unis, de nous garder dans ta paix. Protège notre mariage. Donne-nous d'accueillir des enfants. Ouvre nos coeurs aux autres. Donne-nous d'être fidèles tout au long de notre vie. Accueille-nous un jour au Royaume de ton amour, où nous pourrons te louer dans le bonheur et dans la paix. Amen.
EOT,
        ]);

        $etape3->prieres()->create([
            'titre' => 'Prière universelle',
            'contenu' => <<<'EOT'
Refrain
Oh Jésus, Gilles et Maëva se confient à toi seigneur écoute les
Oh Jésus, Gilles et Maëva se confient à toi seigneur exauce les

Gilles et Maëva sont désormais unis devant Dieu !
Que leur amour soit signe d'un amour plus grand, l'amour même qui vient de toi, notre Dieu…
Refrain

Gilles et Maëva sont appelés à la responsabilité de parents !
Qu'ils sachent éveiller leurs enfants au sens du partage et de la prière…
Refrain

Gilles et Maëva ont dit « oui » devant nous tous, parents et amis !
Que leur engagement de ce jour fortifie notre foi et nourrisse notre espérance…
Refrain

Gilles et Maëva nous rappellent que tout amour doit s'ouvrir sur le monde !
Que nous sachions être présents à nos frères et sœurs, en particulier aux malades et aux laissés-pour-compte…
Refrain
EOT,
        ]);

        // --- Étape 4: TOUTE UNE VIE POUR S'AIMER ---
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

        $etape4->prieres()->create([
            'titre' => 'Bénédiction finale',
            'contenu' => <<<'EOT'
Seigneur notre Dieu, regarde avec bonté ces nouveaux époux et daigne répandre sur eux tes bénédictions :
Qu'ils soient unis dans un même amour et avancent vers une même sainteté.
Qu'ils aient la joie de participer à ton amour créateur et puissent ensemble éduquer leurs enfants.
Qu'ils vivent dans la justice et la charité pour montrer ta lumière à ceux qui te cherchent.
Qu'ils mettent leur foyer au service du monde et répondent aux appels de leur prochain.
Qu'ils soient fortifiés par les sacrifices et les joies de leur vie et sachent témoigner de l'Évangile.
Qu'ils vivent longtemps sans malheur ni maladie et que leur travail à tous deux soit béni.
Qu'ils voient grandir en paix leurs enfants et qu'ils aient le soutien d'une famille heureuse.
Qu'ils parviennent enfin, avec tous ceux qui les ont précédés, dans ta demeure où leur amour ne finira jamais.
Gilles et Maëva, et vous tous ici présents, que Dieu tout-puissant vous bénisse : le Père, le Fils et le Saint-Esprit.
Tous : Amen !
EOT,
        ]);

        $etape4->chants()->create([
            'titre' => 'Je te promets',
            'auteur' => 'D. Diu',
            'paroles' => <<<'EOT'
Devant nos familles devant Dieu je prends ta main et je dis oui Je te vois là Tu me souris Aujourd'hui je t'épouse Pour la vie
Je te promets fidélité Je te promets tendresse Je te promets d'être là Dans la joie et la peine Je te promets mon amour Je te promets ma force Je te promets un foyer Rempli de bonheur
Cette alliance au doigt Symbole d'union Brillera comme Mon amour pour toi Tu es mon choix Tu es ma voie Aujourd'hui je m'engage Auprès de toi
EOT,
        ]);

        $etape4->chants()->create([
            'titre' => 'Abrite-moi',
            'auteur' => 'Traditionnel',
            'paroles' => <<<'EOT'
Abrite-moi sous tes ailes. Couvre-moi par ta main puissante
Même si les océans se déchaînent, je les traverserai avec toi
Père, tu domines les tempêtes, je suis tranquille, car tu es là.
En Jésus seul, je me confie. Il me donne, force, calme et puissance.
Même si les océans se déchaînent, je les traverserai avec toi
Père, tu domines les tempêtes, je suis tranquille, car tu es là.
EOT,
        ]);

        $etape4->prieres()->create([
            'titre' => 'Consécration à la Vierge',
            'contenu' => <<<'EOT'
Ave, Ave, Ave, Ave Maria
Ave Maria
Ave Maria
Ave, Ave Maria
Ave Maria
Aaaaa ve Mariia
Aaaa ve Aave,
Ave, Ave, Ave, Ave Maria
Ave Maria
Ave Maria
Ave Maria
Aaave Maaaaria
Aave Maaaaria
Aaaave, Aaaaa ve, Ave
AVE MARIA - SUR LA MÉLODIE DE "HALLELUJAH" DE LÉONARD COHEN
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