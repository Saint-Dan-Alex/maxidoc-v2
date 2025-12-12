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
            // Direction Générale
            ["Direction Générale", "Directeur Générale", "Erwan JEHANO", "erwanjehano@lerexcompetroleum.com"],
            ["Direction Générale", "Secretaire de Direction", "Gaelle EKOSA", "gaelleekosa@lerexcompetroleum.com"],
            
            // Département Appro
            ["Departement Appro", "Manager Appro", "Nixon BOLEKI", "nixonboleki@lerexcompetroleum.com"],
            ["Departement Appro", "Ass Appro Kinshasa", "Antho MOMBELA", "anthomombela@lerexcompetroleum.com"],
            
            // Département Business Analyse
            ["Departement Business Analyse", "Manager Business Analyste", "Jean Claude LENGO", "jeanclaudelengo@lerexcompetroleum.com"],
            ["Departement Business Analyse", "Chargé des projets & Controleur interne", "Gaby-José ABABA", "gabyjoseababa@lerexcompetroleum.com"],
            ["Departement Business Analyse", "Controleur perte & Coulage Kinshasa", "Gael KIKUNGA", "gaelkikunga@lerexcompetroleum.com"],
            ["Departement Business Analyse", "Controleur perte & Coulage Matadi", "Ephraim MAYAZOLA", "ephraimmayazola@lerexcompetroleum.com"],
            ["Departement Business Analyse", "Controleur perte & Coulage Kinshasa", "Chris MUNJILE", "chrismunjile@lerexcompetroleum.com"],
            
            // Département HSSEQ (PFSO)
            ["Departement HSSEQ (PFSO)", "Manager HSSEQ (PFSO)", "Guy MBUYI", "guymbuyi@lerexcompetroleum.com"],
            ["Departement HSSEQ (PFSO)", "Superviseur HSSEQ (PFSO) Matadi", "Pitshou NGALIEMA", "pitshoungaliema@lerexcompetroleum.com"], // Assumed Matadi/Kinshasa swap based on list vs code? User list says Matadi: Pitshou. Code said Kinshasa. sticking to user list role if possible, but user list has Pitshou as Matadi? No, user list says: Superviseur HSSEQ (PFSO) Matadi: Pitshou NGALIEMA.
            ["Departement HSSEQ (PFSO)", "Superviseur HSSEQ (PFSO) Kinshasa", "Belaire MAMPASI", "belairemampasi@lerexcompetroleum.com"], // Swap to match user list logic? User list says: Superviseur HSSEQ (PFSO) Kinshasa: Belaire MAMPASI.
            ["Departement HSSEQ (PFSO)", "Safety Officer Matadi", "Nicky MBUYI", "nickymbuyi@lerexcompetroleum.com"],
            ["Departement HSSEQ (PFSO)", "Safety Officer Kinshasa", "MBELA BASOLA", "mbelabasola@lerexcompetroleum.com"],
            
            // Direction Administrative
            ["Direction Administrative", "Directeur Administratif", "Patrick MBALA", "patrickmbala@lerexcompetroleum.com"],
            ["Direction Administrative", "Manager des ressources humaines", "Marie Thérèse MBUILA", "marietheresembuila@lerexcompetroleum.com"],
            // Gestion carrière & paie
            ["Direction Administrative", "Resp. Camère & Paie", "Celestin NDJONDO", "celestinndjondo@lerexcompetroleum.com"],
            ["Direction Administrative", "Service Intendant Maluku", "Bruno KILUNGILA", "brunokilungila@lerexcompetroleum.com"],
            ["Direction Administrative", "Support Administratif", "Nicodem NGOYI", "nicodemngoyi@lerexcompetroleum.com"],
            ["Direction Administrative", "Ass. Administratif", "Clovis MASAMBA", "clovismasamba@lerexcompetroleum.com"],
            // Adm & Sce Généraux
            ["Direction Administrative", "Resp. Adm & Sce Généraux", "Nisha MANZAMBI", "nishamanzambi@lerexcompetroleum.com"],
            ["Direction Administrative", "Magasinier Maluku", "Eureka MULONDOLEWA", "eurekamulondolewa@lerexcompetroleum.com"],
            ["Direction Administrative", "Ass. Magasinier Maluku", "Vanessa MAMAS", "vanessamamas@lerexcompetroleum.com"],
            ["Direction Administrative", "Magasinier Matadi", "Jimmy NKASSA", "jimmynkassa@lerexcompetroleum.com"],
            // IT
            ["Direction Administrative", "Superviseur IT Matadi", "Christel MANTUMBU", "christelmantumbu@lerexcompetroleum.com"],
            ["Direction Administrative", "IT Support Matadi", "Nehemie MALUTA", "nehemiemaluta@lerexcompetroleum.com"],
            ["Direction Administrative", "Superviseur IT KINSHASA", "Caleb TSHINGA", "calebtshinga@lerexcompetroleum.com"],
            ["Direction Administrative", "IT Support Kinshasa-Maluku", "Fleury NGOMA", "fleuryngoma@lerexcompetroleum.com"],
            ["Direction Administrative", "IT Support Kinshasa-Limete", "Chadrack MUANDA", "chadrackmuanda@lerexcompetroleum.com"],
            
            // Direction Financière
            ["Direction Financière", "Directeur Technique", "Leon LUMWANGA", "leonlumwanga@lerexcompetroleum.com"], // Title in user list is "Directeur Technique" under Finance? Might be "Directeur Financier". Keeping user list "Directeur Technique".
            ["Direction Financière", "Manager Comptable", "Serge MBELE", "sergembele@lerexcompetroleum.com"],
            ["Direction Financière", "Trésorière Principale", "Brigitte MAHALO", "brigittemahalo@lerexcompetroleum.com"],
            // Comptabilité
            ["Direction Financière", "Ass. Chef Comptable", "Robert BULANI", "robertbulani@lerexcompetroleum.com"],
            ["Direction Financière", "Comptabilité Analytique", "Mimiche MATUAZOLA", "mimichematuazola@lerexcompetroleum.com"],
            ["Direction Financière", "Comptabilité Générale", "Tiana GIBANGO", "tianagibango@lerexcompetroleum.com"], // Added correction
            // Douane & Transit
            ["Direction Financière", "Agent Transit Matadi", "Joel NYEMBA", "joelnyemba@lerexcompetroleum.com"],
            ["Direction Financière", "Agent Transit Matadi", "Bernice AKANYI", "berniceakanyi@lerexcompetroleum.com"],
            ["Direction Financière", "Facturation & Récouvrement", "Christian KABANGE", "christiankabange@lerexcompetroleum.com"],
            // Caisse
            ["Direction Financière", "Caissière Principale", "Delphine LUKOKI", "delphinelukoki@lerexcompetroleum.com"],
            ["Direction Financière", "Caissière Matadi", "Mirlette KITSHIABI", "mirlettekitshiabi@lerexcompetroleum.com"],
            ["Direction Financière", "Caissière Maluku", "Julie TABORIA", "julietaboria@lerexcompetroleum.com"],
            
            // Direction des Opérations
            ["Direction des Opérations", "Directeur des Opérations", "Hervé MFUAMBA", "hervemfuamba@lerexcompetroleum.com"],
            // Terminaux
            ["Direction des Opérations", "Manager Terminal/PFSO Matadi", "Patrick NIMWA", "patricknimwa@lerexcompetroleum.com"],
            ["Direction des Opérations", "Team Leader Matadi", "Hugo NSIAMPA", "hugonsiampa@lerexcompetroleum.com"],
            ["Direction des Opérations", "Team Leader Kinshasa", "Joe NZINGA", "joenzinga@lerexcompetroleum.com"],
            ["Direction des Opérations", "Ass. Team Leader Kinshasa", "Bianco KIDIMBU", "biancokidimbu@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Glody MAYUKU", "glodymayuku@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Fabrice IYOLO", "fabriceiyolo@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Elvis LIANDJA", "elvisliandja@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Edmond BOKA", "edmondboka@lerexcompetroleum.com"],
            ["Direction des Opérations", "Opérateur Polyvalent", "Guyguy MANKENDA", "guyguymankenda@lerexcompetroleum.com"],
            
            // Supervision Convois
            ["Direction des Opérations", "Superviseur de Convois", "Yves NGOIE", "yvesngoie@lerexcompetroleum.com"],
            ["Direction des Opérations", "Superviseur de Convois", "Cedrick TSHIYAMBA", "cedricktshiyamba@lerexcompetroleum.com"],
            
            // Transport & Dispatching
            ["Direction des Opérations", "Superviseur des Opérations", "Dominique KILINDA", "dominiquekilinda@lerexcompetroleum.com"],
            ["Direction des Opérations", "Superviseur Dispatsheur", "Flavien MAKUMBI", "flavienmakumbi@lerexcompetroleum.com"],
            ["Direction des Opérations", "Dispatcheur Matadi", "Glody MATUMONA", "glodymatumona@lerexcompetroleum.com"],
            ["Direction des Opérations", "Dispatcheur Kinshasa", "Nachrist LOGA", "nachristloga@lerexcompetroleum.com"],
            ["Direction des Opérations", "Ass. Dispatche Kinshasa", "Jude KAMBA", "judekamba@lerexcompetroleum.com"],
            
            // Autres Ops
            ["Direction des Opérations", "Agent Station Rélais Kimpese", "Paul MATONDO", "paulmatondo@lerexcompetroleum.com"],
            ["Direction des Opérations", "Pompiste & Jauguer", "Eric LENGO DIA NDINGA", "ericlengo@lerexcompetroleum.com"],
            
            // Direction Technique
            ["Direction Technique", "Directeur Technique", "Cyrille NTITI", "cyrillentiti@lerexcompetroleum.com"],
            ["Direction Technique", "Manager Technique", "Jonathan MABOKO", "jonathanmaboko@lerexcompetroleum.com"],
            ["Direction Technique", "Chef Mécanicien", "Paul MAMBU", "paulmambu@lerexcompetroleum.com"],
            ["Direction Technique", "Planificateur Technique", "Bob BISELENGE", "bobbiselenge@lerexcompetroleum.com"],
            
            // Maintenance Matadi
            ["Direction Technique", "Superviseur Technique", "Gerard MOKE", "gerardmoke@lerexcompetroleum.com"],
            ["Direction Technique", "Chef Garage", "Alexis MUVUNGU", "alexismuvungu@lerexcompetroleum.com"], // Assuming Chef Garage role exists in seeder functions
            ["Direction Technique", "Metrologue", "Figo BATOBA", "figobatoba@lerexcompetroleum.com"],
            ["Direction Technique", "Electricien", "Figo BATOBA", "figobatoba2@lerexcompetroleum.com"], // Same name?
            
            // Maintenance Kinshasa
            ["Direction Technique", "Superviseur Technique", "Joel LUBULU", "joellubulu@lerexcompetroleum.com"],
            ["Direction Technique", "Chef Garage", "Willy BATOBA", "willybatoba@lerexcompetroleum.com"],
            ["Direction Technique", "Metrologue", "Rondal MAMPUYA", "rondalmampuya@lerexcompetroleum.com"],
            ["Direction Technique", "Génie Civile", "Michel SAMBA", "michelsamba@lerexcompetroleum.com"],
            ["Direction Technique", "Electricien", "Dido KINSOMPA", "didokinsompa@lerexcompetroleum.com"],
            
            // Labo
            ["Direction Technique", "Superviseur Laboratoire", "Jerome GALAMA", "jeromegalama@lerexcompetroleum.com"],
            ["Direction Technique", "Technicien Lab. Kinshasa 1", "Aurélie NKAYILU", "aurelienkayilu@lerexcompetroleum.com"],
            ["Direction Technique", "Technicien Lab. Matadi 1", "Jacob BADIBANGA", "jacobbadibanga@lerexcompetroleum.com"],
            ["Direction Technique", "Technicien Lab. Matadi 2", "Van BUMBA", "vanbumba@lerexcompetroleum.com"],
            
            // Direction Commerciale
            ["Direction Commerciale", "Directrice Commerciale", "Alicia NSISI", "aliciansisi@lerexcompetroleum.com"],
            ["Direction Commerciale", "Manager Com. & Gest Stock", "Thérèsia DIFIMA", "theresiadifima@lerexcompetroleum.com"],
            ["Direction Commerciale", "Superviseur Commerciale", "Nathalie BILONDA", "nathaliebilonda@lerexcompetroleum.com"],
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
        // ================================
        // 4. INSERTION EN BASE
        // ================================
        foreach ($agents as $data) {
            $direction = null;
            $service = null;
            
            // 1. Essayer de trouver une Direction correspondante
            $directionFound = DB::table('directions')->where('titre', $data['direction_titre'])->first();
            
            if ($directionFound) {
                // C'est une Direction principale
                $direction = $directionFound;
                // On pourrait essayer de déduire le service via la fonction, mais restons simple pour l'instant
            } else {
                // 2. Si pas une Direction, c'est peut-être un Service (ex: Departement Appro)
                // Dans ce cas, on cherche le service, et on récupère sa direction parente
                $serviceFound = DB::table('services')->where('titre', $data['direction_titre'])->first();
                
                if ($serviceFound) {
                    $service = $serviceFound;
                    $direction = DB::table('directions')->where('id', $service->direction_id)->first();
                }
            }

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
                'service_id' => $service ? $service->id : null,
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
