<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AgentSeeder extends Seeder
{
    public function run(): void
    {
        // ================================
        // 1. LIEUX D'AFFECTATION
        // ================================
        $lieux = [
            'Kinshasa-Limete',
            'Kinshasa-Maluku',
            'Matadi',
        ];

        foreach ($lieux as $titre) {
            if (!DB::table('lieu_affectations')->where('titre', $titre)->exists()) {
                DB::table('lieu_affectations')->insert([
                    'titre' => $titre,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ================================
        // 2. LISTE BRUTE IMPORTÉE
        // ================================
        $rawAgents = [
            ["Direction Générale", "Directeur Générale", "Erwan JEHANO", "erwanjehanno@lerexcompetroleum.com"],
            ["Direction Générale", "Secretaire de Direction", "Gaelle EKOSA", "gaelleekosa@lerexcompetroleum.com"],
            ["Departement Appro", "Manager Appro", "Nixon BOLEKI", "nixonboleki@lerexcompetroleum.com"],
            ["Departement Appro", "Ass Appro Kinshasa", "Antho MOMBELA", "anthomombela@lerexcompetroleum.com"],
            ["Departement Business Analyse", "Manager Business Analyste", "Jean Claude LENGO", "jeanclaudelengo@lerexcompetroleum.com"],
            ["Departement Business Analyse", "Chargé des projets & Controleur interne", "Gaby-José ABABA", "gabyjoseababa@lerexcompetroleum.com"],
            ["Departement Business Analyse", "Controleur perte & Coulage Kinshasa", "Gael KIKUNGA", "gaelkikunga@lerexcompetroleum.com"],
            ["Departement Business Analyse", "Controleur perte & Coulage Matadi", "Ephaim MAYAZOLA", "ephraimmayazola@lerexcompetroleum.com"],
            ["Departement Business Analyse", "Controleur perte & Coulage Kinshasa", "Chris MUNJILE", "chrismondjile@lerexcompetroleum.com"],
            ["Departement HSSEQ (PFSO)", "Manager HSSEQ (PFSO)", "Guy MBUYI", "guymbuyi@lerexcompetroleum.com"],
            ["Departement HSSEQ (PFSO)", "Superviseur HSSEQ (PFSO) Matadi", "", ""],
            ["Departement HSSEQ (PFSO)", "Superviseur HSSEQ (PFSO) Kinshasa", "Pitshou NGALIEMA", "pitshoungallema@lerexcompetroleum.com"],
            ["Departement HSSEQ (PFSO)", "Safety Officer Matadi", "Belaire MAMPASI", "belairemampasi@lerexcompetroleum.com"],
            ["Departement HSSEQ (PFSO)", "Safety Officer Kinshasa", "Nicky MBUYI", "nickymbuyi@lerexcompetroleum.com"],
            ["Departement HSSEQ (PFSO)", "Sapeur Pompier", "MBELA BASOLA", "mbelabasola@lerexcompetroleum.com"],
            ["Direction Administratif", "Directeur Administratif", "Patrick MBALA", "patrickmbala@lerexcompetroleum.com"],
            ["Direction Administratif", "Manager des ressources humaines", "Marie Thérèse MBUILA", "marie-theresembulia@lerexcompetroleum.com"],
            ["Direction Administratif", "Resp. Camère & Paie", "Celestin NDJONDO", "celestinndjondo@lerexcompetroleum.com"],
            ["Direction Administratif", "Service Intendant Maluku", "Bruno KILUNGILA", "brunokilunglia@lerexcompetroleum.com"],
            ["Direction Administratif", "Support Administratif", "Nicodem NGOYI", "nicodemngoyi@lerexcompetroleum.com"],
            ["Direction Administratif", "Ass. Administratif", "Clovis MASAMBA", "clovismasamba@lerexcompetroleum.com"],
            ["Direction Administratif", "Resp. Adm & Sce Généraux", "Nisha MANZAMBI", "lanishamanzambi@lerexcompetroleum.com"],
            ["Direction Administratif", "Magasinier Maluku", "Eureka MULONDOLEWA", "eurekamulondelwa@lerexcompetroleum.com"],
            ["Direction Administratif", "Ass. Magasinier Maluku", "Vanessa MAMAS", "vanessamamas@lerexcompetroleum.com"],
            ["Direction Administratif", "Magasinier Matadi", "Jimmy NKASSA", "jimmynkasa@lerexcompetroleum.com"],
            ["Direction Administratif", "Superviseur IT Matadi", "Christel MANTUMBU", "chrismantumbu@lerexcompetroleum.com"],
            ["Direction Administratif", "IT Support Matadi", "Nehemie MALUTA", "nehemiemaluta@lerexcompetroleum.com"],
            ["Direction Administratif", "Superviseur IT KINSHASA", "Caleb TSHINGA", "calebtshinga@lerexcompetroleum.com"],
            ["Direction Administratif", "IT Support Kinshasa-Maluku", "Fleury NGOMA", "fleuryngoma@lerexcompetroleum.com"],
            ["Direction Administratif", "IT Support Kinshasa-Limete", "Chadrack MUANDA", "fleuryngoma@lerexcompetroleum.com"],
            ["Direction des Opérations", "Directeur des Opérations", "Hervé MFUAMBA", "hervemfuamba@lerexcompetroleum.com"],
            ["Direction des Opérations", "Manager Terminal/PFSO Kinshasa", "Jacque MASHALA", "jackmashala@lerexcompetroleum.com"],
            ["Direction des Opérations", "Manager Terminal/PFSO Matadi", "Patrick NIMWA", "hugonsiampa@lerexcompetroleum.com"],
            ["Direction des Opérations", "Team Leader Matadi", "Hugo NSIAMPA", "patricknimwa@lerexcompetroleum.com"],
            ["Direction des Opérations", "Team Leader Kinshasa", "Joe NZINGA", "joenzinga@lerexcompetroleum.com"],
            ["Direction des Opérations", "Ass. Team Leader Kinshasa", "Bianco KIDIMBU", "biancokidimbu@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Glody MAYUKU", "glodymayuku@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Fabrice IYOLO", "elvisliandja@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Elvis LIANDJA", "fabriceiyolo@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Edmond BOKA", "guyguymankenda@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Guyguy MANKENDA", "jonathankiala@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Guyguy MANKENDA", "edmondboka@lerexcompetroleum.com"],
            ["Direction des Opérations", "Superviseur de Convois", "Yves NGOIE", "yvesngoie@lerexcompetroleum.com"],
            ["Direction des Opérations", "Superviseur de Convois", "Cedrick TSHIYAMBA", "cedricktshiyamba@lerexcompetroleum.com"],
            ["Direction des Opérations", "Superviseur des Opérations", "Dominique KILINDA", "gerardmoke@lerexcompetroleum.com"],
            ["Direction des Opérations", "Superviseur Dispatsheur", "Flavien MAKUMBI", "flavienmakumbi@lerexcompetroleum.com"],
            ["Direction des Opérations", "Dispatcheur Matadi", "Glody MATUMONA", "glodymatumona@lerexcompetroleum.com"],
            ["Direction des Opérations", "Dispatcheur Kinshasa", "Nachrist LOGA", "nachristloga@lerexcompetroleum.com"],
            ["Direction des Opérations", "Ass. Dispatche Kinshasa", "Jude KAMBA", "judekamba@lerexcompetroleum.com"],
            ["Direction des Opérations", "Agent Station Rélais Kimpese", "Paul MATONDO", "paulmatondo@lerexcompetroleum.com"],
            ["Direction des Opérations", "Pompiste & Jauguer", "Eric LENGO DIA NDINGA", "ericklengo@lerexcompetroleum.com"],
            ["Direction Technique", "Directeur Technique", "Cyrille NTITI", "cyrillentiti@lerexcompetroleum.com"],
            ["Direction Technique", "Manager Technique", "Jonathan MABOKO", "jonathanmaboko@lerexcompetroleum.com"],
            ["Direction Technique", "Chef Mécanicien", "Paul MAMBU", "bobbiselenge@lerexcompetroleum.com"],
            ["Direction Technique", "Planificateur Technique", "Bob BISELENGE", "paulmambu@lerexcompetroleum.com"],
            ["Direction Technique", "Superviseur Technique", "Gerard MOKE", "gerardmoke@lerexcompetroleum.com"],
            ["Direction Technique", "Metrologue", "Alexis MUVUNGU", "alexismuvumbu@lerexcompetroleum.com"],
            ["Direction Technique", "Electricien", "Figo BATOBA", "figobatoba@lerexcompetroleum.com"],
            ["Direction Technique", "Superviseur Technique", "Joel LUBULU", "joellubulu@lerexcompetroleum.com"],
            ["Direction Technique", "Metrologue", "Rondal MAMPUYA", "michelsamba@lerexcompetroleum.com"],
            ["Direction Technique", "Génie Civile", "Michel SAMBA", "didokisompa@lerexcompetroleum.com"],
            ["Direction Technique", "Electricien", "Dido KINSOMPA", "rondalmampuya@lerexcompetroleum.com"],
            ["Direction Technique", "Superviseur Laboratoire", "Jerome GALAMA", "jeromegalama@lerexcompetroleum.com"],
            ["Direction Technique", "Technicien Lab. Kinshasa 1", "Aurélie NKAYILU", "flavienmakumbi@lerexcompetroleum.com"],
            ["Direction Technique", "Technicien Lab. Matadi 1", "Jacob BADIBANGA", "jacobbadibanga@lerexcompetroleum.com"],
            ["Direction Technique", "Technicien Lab. Matadi 2", "Van BUMBA", "vanbumba@lerexcompetroleum.com"],
            ["Direction Financier", "Directeur Technique", "Leon LUMWANGA", "leonlumwanga@lerexcompetroleum.com"],
            ["Direction Financier", "Manager Comptable", "Serge MBELE", "sergembele@lerexcompetroleum.com"],
            ["Direction Financier", "Trésorière Principale", "Brigitte MAHALO", "brigittemahalo@lerexcompetroleum.com"],
            ["Direction Financier", "Ass. Chef Comptable", "Robert BULANI", "robertbulani@lerexcompetroleum.com"],
            ["Direction Financier", "Comptabilité Analytique", "Mimiche MATUAZOLA", "mimichematuazola@lerexcompetroleum.com"],
            ["Direction Financier", "Douane & Transit", "", ""],
            ["Direction Financier", "Agent Transit Matadi", "Joel NYEMBA", "berniceakanyi@lerexcompetroleum.com"],
            ["Direction Financier", "Agent Transit Matadi", "Bernice AKANYI", "joelnyemba@lerexcompetroleum.com"],
            ["Direction Financier", "Douane & Transit", "", ""],
            ["Direction Financier", "Facturation & Récouvrement", "Christian KABANGE", "christiankabange@lerexcompetroleum.com"],
            ["Direction Financier", "Caissière Principale", "Delphine LUKOKI", "delphinelukoki@lerexcompetroleum.com"],
            ["Direction Financier", "Caissière Matadi", "Mirlette KITSHIABI", "julietaboria@lerexcompetroleum.com"],
            ["Direction Financier", "Caissière Maluku", "Julie TABORIA", "mirlettekitshiabi@lerexcompetroleum.com"],
            ["Direction Commerciale", "Directrice Commerciale", "Alicia NSISI", "aliciansisi@lerexcompetroleum.com"],
            ["Direction Commerciale", "Manager Com. & Gest Stock", "Thérèsia DIFIMA", "theresiadifima@lerexcompetroleum.com"],
            ["Direction Commerciale", "Superviseur Commerciale", "Nathalie BILONDA", "nathaliebona@lerexcompetroleum.com"],
            ["Direction Commerciale", "Agent Commerciale", "Julie MALONDA", "juliemalonda@lerexcompetroleum.com"],
            ["Direction Commerciale", "Superviseur Gest. Stocks", "Danny OMALANGA", "dannyomalanga@lerexcompetroleum.com"],
            ["Direction Commerciale", "Gestionnaire des stocks", "Virginie MANKIKISA", "virginiemankikisa@lerexcompetroleum.com"],
        ];

        // ================================
        // 3. TRANSFORMATION AUTOMATIQUE
        // ================================
        $agents = [];
        $counter = 1;

        foreach ($rawAgents as $a) {
            [$direction, $fonction, $fullname, $email] = $a;

            if (empty(trim($fullname)) || empty(trim($email))) continue;

            $parts = explode(" ", $fullname);
            $prenom = array_shift($parts);
            $nom = array_pop($parts);
            $postnom = implode(" ", $parts);

            $lieu =
                str_contains($fonction, 'Matadi') ? 'Matadi' :
                (str_contains($fonction, 'Maluku') ? 'Kinshasa-Maluku' : 'Kinshasa-Limete');

            $agents[] = [
                "nom" => $nom,
                "post_nom" => $postnom,
                "prenom" => $prenom,
                "direction_titre" => $direction,
                "fonction_titre" => $fonction,
                "email" => $email,
                "matricule" => "AGENT" . str_pad($counter++, 3, "0", STR_PAD_LEFT),
                "sexe" => "M",
                "lieu_titre" => $lieu,
            ];
        }

        // ================================
        // 4. INSERTION EN BASE
        // ================================
        foreach ($agents as $data) {
            $direction = DB::table('directions')->where('titre', $data['direction_titre'])->first();
            $fonction = DB::table('fonctions')->where('titre', $data['fonction_titre'])->first();
            $lieu = DB::table('lieu_affectations')->where('titre', $data['lieu_titre'])->first();

            if (!$direction || !$fonction || !$lieu) continue;

            if (DB::table('users')->where('email', $data['email'])->exists()) continue;

            $userId = DB::table('users')->insertGetId([
                'email' => $data['email'],
                'name' => Str::title("$data[prenom] $data[nom]"),
                'password' => Hash::make('12345678'),
                'statut_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('agents')->insert([
                'user_id' => $userId,
                'direction_id' => $direction->id,
                'fonction_id' => $fonction->id,
                'lieu_id' => $lieu->id,
                'statut_id' => 1,
                'nom' => ucfirst(strtolower($data['nom'])),
                'post_nom' => ucfirst(strtolower($data['post_nom'])),
                'prenom' => ucfirst(strtolower($data['prenom'])),
                'sexe' => $data['sexe'],
                'matricule' => $data['matricule'],
                'slug' => Str::slug("$data[nom] $data[post_nom] $data[prenom]"),
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
