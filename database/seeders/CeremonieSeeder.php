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
        // Pour PostgreSQL, nous utilisons une approche différente pour vider les tables
        // sans désactiver les contraintes de clés étrangères
        
        // Supprimer les enregistrements dans l'ordre inverse des relations
        // pour éviter les violations de contraintes de clés étrangères
        DB::table('memory_cards')->delete();
        DB::table('prieres')->delete();
        DB::table('chants')->delete();
        DB::table('lectures')->delete();
        DB::table('etape_ceremonies')->delete();
        DB::table('remerciements')->delete();
        
        // Réinitialiser les séquences d'auto-incrémentation
        DB::statement("ALTER SEQUENCE memory_cards_id_seq RESTART WITH 1");
        DB::statement("ALTER SEQUENCE prieres_id_seq RESTART WITH 1");
        DB::statement("ALTER SEQUENCE chants_id_seq RESTART WITH 1");
        DB::statement("ALTER SEQUENCE lectures_id_seq RESTART WITH 1");
        DB::statement("ALTER SEQUENCE etape_ceremonies_id_seq RESTART WITH 1");
        DB::statement("ALTER SEQUENCE remerciements_id_seq RESTART WITH 1");

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
        $etape1 = EtapeCeremonie::create(['ordre' => 1, 'titre' => 'OUVERTURE DE LA CÉRÉMONIE', 'icone' => 'fa-solid fa-door-open', 'termine' => true]);
        $etape2 = EtapeCeremonie::create(['ordre' => 2, 'titre' => 'DIEU NOUS PARLE', 'icone' => 'fa-solid fa-book-bible', 'en_cours' => true]);
        $etape3 = EtapeCeremonie::create(['ordre' => 3, 'titre' => 'DIEU NOUS UNIT', 'icone' => 'fa-solid fa-hands-praying']);
        $etape4 = EtapeCeremonie::create(['ordre' => 4, 'titre' => 'TOUTE UNE VIE POUR S\'AIMER', 'icone' => 'fa-solid fa-heart']);
        $etape5 = EtapeCeremonie::create(['ordre' => 5, 'titre' => 'REMERCIEMENTS', 'icone' => 'fa-solid fa-champagne-glasses']);

        // === 3. Création des lectures, chants et prières associés ===

        // --- Étape 1: OUVERTURE ---
        $etape1->chants()->create(['titre' => 'Que tes œuvres sont belles', 'auteur' => 'Traditionnel', 'paroles' => "Que tes œuvres sont belles,\nQue tes œuvres sont grandes !\nSeigneur, Seigneur, tu nous combles de joie.\nQue tes œuvres sont belles,\nQue tes œuvres sont grandes !\nSeigneur, Seigneur, tu nous combles de joie.\n\n1\nC'est toi, le Dieu qui nous as faits, qui nous as pétris de la terre !\nTout homme est une histoire sacrée, l'homme est à l'image de Dieu !\nTon amour nous a façonnés, tirés du ventre de la terre !\nTout homme est une histoire sacrée, l'homme est à l'image de Dieu !"]);
        
        $etape1->chants()->create(['titre' => 'Psaumes de la création', 'auteur' => 'A. Dumont', 'paroles' => "1er couplet\nPar les cieux devant toi, splendeur et majesté\nPar l'infiniment grand, l'infiniment petit\nEt par le firmament, ton manteau étoilé,\nEt par frère soleil, je veux crier :\nRefrain\nMon Dieu, tu es grand, tu es beau,\nDieu vivant, Dieu très haut, tu es le Dieu d'amour ;\nMon Dieu, tu es grand, tu es beau,\nDieu vivant, Dieu très haut,\nDieu présent, en toute création.\n5e couplet\nPar cette main tendue qui invite à la danse\nPar ce baiser jailli d'un élan d'espérance\nPar ce regard d'amour qui relève et réchauffe\nPar le pain et le vin, je veux crier :"]);

        // --- Étape 2: DIEU NOUS PARLE ---
        $etape2->lectures()->create(['titre' => 'Lecture du Livre de la Genèse', 'reference' => 'Genèse 1, 26-28.31a', 'contenu' => "Au commencement, Dieu dit: « Faisons l'homme à notre image, selon notre ressemblance. Qu'il soit le maître des poissons de la mer, des oiseaux du ciel, des bestiaux, de toutes les bêtes sauvages et de toutes les bestioles qui vont et viennent sur la terre »\nDieu créa l'homme à son image, à l'image de Dieu il créa, il les créa homme et femme.\nDieu les bénit et leur dit : « Soyez féconds et multipliez-vous, remplissez la terre et soumettez-la. Soyez les maîtres des poissons de la mer, des oiseaux du ciel, et de tous les animaux qui vont et viennent sur la terre »\nEt Dieu vit tout ce qu'il avait fait : c'était très bon."]);
        
        $etape2->lectures()->create(['titre' => 'Évangile de Jésus Christ selon Saint Jean', 'reference' => 'Jean 17, 20-26', 'contenu' => "À l'heure où Jésus passait de ce monde à son père, il leva les yeux au ciel et pria ainsi : « Père, je ne prie pas seulement pour ceux qui sont là, mais encore pour ceux qui accueilleront leur parole et croiront en moi : Que tous, ils soient un, comme toi, Père, tu es en moi, et moi en toi. Qu'ils soient un en nous, eux aussi, pour que le monde croie que tu m'as envoyé. Et moi, je leur ai donné la gloire que tu m'as donnée, pour qu'ils soient un comme nous sommes un : moi en eux, et toi en moi. Que leur unité soit parfaite ; ainsi, le monde saura que tu m'as envoyé et que tu les as aimés comme tu m'as aimé. »"]);

        $etape2->chants()->create(['titre' => 'Psaume 148', 'auteur' => 'Traditionnel', 'paroles' => "Alléluia, louez le Seigneur, alléluia, alléluia !\nLouez le Seigneur du haut des cieux,\nlouez-le dans les hauteurs.\nVous, tous ses anges, louez-le,\nlouez-le, tous les univers.\nLouez-le, soleil et lune,\nlouez-le, tous les astres de lumière ;\nvous, cieux des cieux, louez-le,\net les eaux des hauteurs des cieux.\nLes rois de la terre et tous les peuples,\nles princes et tous les juges de la terre ;\ntous les jeunes gens et jeunes filles,\nles vieillards comme les enfants.\nQu'ils louent le nom du Seigneur,\nle seul au-dessus de tout nom;\nsur le ciel et sur la terre, sa splendeur :\nil accroît la vigueur de son peuple."]);

        // --- Étape 3: DIEU NOUS UNIT ---
        $etape3->chants()->create(['titre' => 'Viens, Esprit du Dieu vivant', 'auteur' => 'H. Le Bars', 'paroles' => "Viens esprit du dieu vivant, esprit d'amour\nLumière Bienheureuse nous t'attendons\nViens esprit de vérité, souffle de feu\nEmbrase-nous, purifie-nous et guéris-nous\n\nViens Esprit Saint, Onction céleste\nRemplis nos cœurs de ta présence\nRévèle nous l'amour du Père\nAgis en nous transforme nous"]);

        $etape3->prieres()->create(['titre' => 'Bénédiction Nuptiale', 'contenu' => "Père très saint, créateur du monde, toi qui as fait l'homme et la femme à ton image, toi qui as voulu leur union et qui l'as bénie, nous te prions humblement pour Gilles et Maëva qui sont unis aujourd'hui par le sacrement de mariage.\nQue ta bénédiction descende en abondance sur eux.\nQue la force de l'Esprit Saint les enflamme de ton amour; Qu'ils trouvent le bonheur en se donnant l'un à l'autre ; [Que des enfants viennent embellir leur foyer et que l'Église en soit enrichie.] Dans la joie, qu'ils sachent te remercier; dans la tristesse, qu'ils se tournent vers toi ; que ta présence les aide dans leur travail; qu'ils te trouvent à leur côté dans l'épreuve pour alléger leur fardeau.\nQu'ils participent à la prière de ton Église et témoignent de toi dans le monde.\nEnfin, après avoir vécu longtemps heureux, qu'ils parviennent, entourés de leurs amis, dans le Royaume des cieux.\nPar Jésus, le Christ, notre Seigneur.\nTous : Amen !"]);

        $etape3->chants()->create(['titre' => 'Comment ne pas te louer', 'auteur' => 'Traditionnel', 'paroles' => "Comment ne pas te louer-er-er\nComment ne pas te louer-er-er\nComment ne pas te louer-er-er Seigneur Jésus !\nComment ? Comment ?\n1.Quand je regarde autour de moi Je vois ta gloire,\nSeigneur Jésus, je te bénis. Comment ne pas te louer-erer, Seigneur Jésus ! Comment ? Comment ?\n2. Quand je regarde autour de moi Je vois mes frères,\nSeigneur Jésus, merci pour eux. Comment ne pas te louer-er-er, Seigneur Jésus ! Comment ? Comment ?"]);

        // --- Étape 4: TOUTE UNE VIE POUR S'AIMER ---
        $etape4->prieres()->create(['titre' => 'Prière des époux', 'contenu' => "Seigneur notre Dieu, tu nous as conduits jusqu'à ce jour de bonheur : nous te disons notre reconnaissance. Tu nous as confiés l'un à l'autre : maintenant, ensemble, nous te confions notre amour.\nNous te demandons, Seigneur, de nous tenir unis, de nous garder dans ta paix. Protège notre mariage. Donne-nous d'accueillir des enfants. Ouvre nos coeurs aux autres. Donne-nous d'être fidèles tout au long de notre vie. Accueille-nous un jour au Royaume de ton amour, où nous pourrons te louer dans le bonheur et dans la paix. Amen."]);

        $etape4->prieres()->create(['titre' => 'Prière de l\'Eglise', 'contenu' => "Refrain\nOh Jésus, Gilles et Maëva se confient à toi seigneur écoute les\nOh Jésus, Gilles et Maëva se confient à toi seigneur exauce les\nGilles et Maëva sont désormais unis devant Dieu !\nQue leur amour soit signe d'un amour plus grand,\nl'amour même qui vient de toi, notre Dieu…\nRefrain\nGilles et Maëva sont appelés à la responsabilité de parents !\nQu'ils sachent éveiller leurs enfants au sens du partage et de la prière…\nRefrain\nGilles et Maëva ont dit « oui » devant nous tous, parents et amis !\nQue leur engagement de ce jour fortifie notre foi et nourrisse notre espérance…\nRefrain\nGilles et Maëva nous rappellent que tout amour doit s'ouvrir sur le monde !\nQue nous sachions être présents à nos frères et sœurs, en particulier aux malades et aux laissés-pour-compte…\nRefrain"]);

        $etape4->prieres()->create(['titre' => 'Notre Père', 'contenu' => "Notre Père qui est aux cieux,\nQue Ton Nom soit sanctifié,\nQue Ton règne vienne,\nQue Ta volonté soit faite\nSur la terre comme au ciel.\nDonne-nous aujourd'hui Notre pain de ce jour.\nPardonne-nous nos offenses Comme nous pardonnons aussi à ceux Qui nous ont offensés.\nEt ne nous laisse pas entrer en tentation, Mais délivre-nous du mal. Amen."]);

        $etape4->chants()->create(['titre' => 'Abrite-moi', 'auteur' => 'Traditionnel', 'paroles' => "Abrite-moi sous tes ailes. Couvre-moi par ta main puissante\n\nMême si les océans se déchaînent, je les traverserai avec toi\nPère, tu domines les tempêtes, je suis tranquille, car tu es là.\n\nEn Jésus seul, je me confie. Il me donne, force, calme et puissance.\n\nMême si les océans se déchaînent, je les traverserai avec toi\nPère, tu domines les tempêtes, je suis tranquille, car tu es là."]);

        $etape4->chants()->create(['titre' => 'Je te promets', 'auteur' => 'D. Diu', 'paroles' => "Devant nos familles devant Dieu je prends ta main et je dis oui Je te vois là Tu me souris Aujourd'hui je t'épouse Pour la vie\nJe te promets fidélité Je te promets tendresse Je te promets d'être là Dans la joie et la peine Je te promets mon amour Je te promets ma force Je te promets un foyer Rempli de bonheur\nCette alliance au doigt Symbole d'union Brillera comme Mon amour pour toi Tu es mon choix Tu es ma voie Aujourd'hui je m'engage Auprès de toi"]);

        $etape4->chants()->create(['titre' => 'Ave Maria', 'auteur' => 'Léonard Cohen', 'paroles' => "Ave,\nAve,\nAve,\nAve Maria\nAve Mari a\nAve Maria\nAve,\nAve Maria\nAve Maria\nAaaaa ve Mariia\nAaaa ve Aave,\nAve,\nAve,\nAve,\nAve Maria\nAve Maria\nAve Maria\nAve Maria\nAaave Maaaaria\nAave Maaaaria\nAaaave,\nAaaaa ve,\nAve\nAVE MARIA - SUR LA MÉLODIE DE \"HALLELUJAH\" DE LÉONARD COHEN"]);

        $etape4->prieres()->create(['titre' => 'Bénédiction Finale', 'contenu' => "Seigneur notre Dieu,\nregarde avec bonté ces nouveaux époux\net daigne répandre sur eux tes bénédictions :\nQu'ils soient unis dans un même amour\net avancent vers une même sainteté.\nQu'ils aient la joie de participer à ton amour créateur\net puissent ensemble éduquer leurs enfants.\nQu'ils vivent dans la justice et la charité\npour montrer ta lumière à ceux qui te cherchent.\nQu'ils mettent leur foyer au service du monde\net répondent aux appels de leur prochain.\nQu'ils soient fortifiés par les sacrifices et les joies\nde leur vie et sachent témoigner de l'Évangile.\nQu'ils vivent longtemps sans malheur ni maladie\net que leur travail à tous deux soit béni.\nQu'ils voient grandir en paix leurs enfants\net qu'ils aient le soutien d'une famille heureuse.\nQu'ils parviennent enfin,\navec tous ceux qui les ont précédés,\ndans ta demeure où leur amour ne finira jamais.\nGilles et Maëva,\net vous tous ici présents,\nque Dieu tout-puissant vous bénisse :\nle Père, le Fils et le Saint-Esprit.\nTous : Amen !"]);

        // --- Étape 5: REMERCIEMENTS ---
        $etape5->chants()->create(['titre' => 'Que ma bouche chante tes louanges', 'auteur' => 'J.P. Lécot', 'paroles' => "De toi, Seigneur, nous attendons la vie,\nQue ma bouche chante ta louange.\nTu es pour nous un rempart, un appui,\nQue ma bouche chante ta louange.\nLa joie du cœur vient de toi ô Seigneur,\nQue ma bouche chante ta louange.\nNotre confiance est dans ton nom très saint !\nQue ma bouche chante ta louange.\n\nSois loué Seigneur, pour ta grandeur,\nSois loué pour tous tes bienfaits.\nGloire à toi Seigneur, tu es vainqueur,\nTon amour inonde nos cœurs.\nQue ma bouche chante ta louange."]);
        
        $etape5->chants()->create(['titre' => 'Evenou Shalom', 'auteur' => 'Traditionnel Hébreu', 'paroles' => "Evenou shalom alerhem !\nEvenou shalom alerhem !\nEvenou shalom alerhem !\nEvenou shalom, shalom, shalom alerhem !\n\n1 - Nous vous annonçons la paix. (Ter)\nNous vous annonçons la paix, la paix, la paix de Jésus !\n2 - Nous vous annonçons la joie...\n3 - Nous vous annonçons l'amour..."]);

        // === 4. Création des paires de cartes pour le jeu Memory ===
        $memoryCards = [
            ['titre' => 'Gilles', 'pair_id' => 'pair-1', 'image_path' => 'memory-cards/gilles.jpg'],
            ['titre' => 'Gilles', 'pair_id' => 'pair-1', 'image_path' => 'memory-cards/gilles.jpg'],
            ['titre' => 'Les Alliances', 'pair_id' => 'pair-2', 'image_path' => 'memory-cards/anneaux.jpg'],
            ['titre' => 'Les Alliances', 'pair_id' => 'pair-2', 'image_path' => 'memory-cards/anneaux.jpg'],
            ['titre' => 'Le Baiser', 'pair_id' => 'pair-3', 'image_path' => 'memory-cards/baiser.jpg'],
            ['titre' => 'Le Baiser', 'pair_id' => 'pair-3', 'image_path' => 'memory-cards/baiser.jpg'],
            ['titre' => 'Le Livret', 'pair_id' => 'pair-4', 'image_path' => 'memory-cards/livret.jpg'],
            ['titre' => 'Le Livret', 'pair_id' => 'pair-4', 'image_path' => 'memory-cards/livret.jpg'],
            ['titre' => 'Maëva', 'pair_id' => 'pair-5', 'image_path' => 'memory-cards/maeva.jpg'],
            ['titre' => 'Maëva', 'pair_id' => 'pair-5', 'image_path' => 'memory-cards/maeva.jpg'],
            ['titre' => 'Eglise', 'pair_id' => 'pair-6', 'image_path' => 'memory-cards/eglise.jpg'],
            ['titre' => 'Eglise', 'pair_id' => 'pair-6', 'image_path' => 'memory-cards/eglise.jpg'],
            ['titre' => 'Mairie', 'pair_id' => 'pair-7', 'image_path' => 'memory-cards/mairie.jpg'],
            ['titre' => 'Mairie', 'pair_id' => 'pair-7', 'image_path' => 'memory-cards/mairie.jpg'],
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