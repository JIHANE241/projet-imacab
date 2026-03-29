<?php

namespace Database\Seeders;

use App\Models\Offre;
use App\Models\Direction;
use App\Models\Category;
use App\Models\TypeContrat;
use App\Models\NiveauExperience;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OffresTestSeeder extends Seeder
{
    public function run()
    {
        $directions = Direction::all();
        if ($directions->isEmpty()) {
            $this->command->error('Aucune direction trouvée. Veuillez d\'abord créer des directions.');
            return;
        }

        $categories = Category::all();
        $typeContrats = TypeContrat::all();
        $niveauxExp = NiveauExperience::all();

        // Création temporaire si nécessaire
        if ($categories->isEmpty()) {
            $categories = $this->createTemporaryCategories();
        }
        if ($typeContrats->isEmpty()) {
            $typeContrats = $this->createTemporaryTypeContrats();
        }
        if ($niveauxExp->isEmpty()) {
            $niveauxExp = $this->createTemporaryNiveauxExp();
        }

        foreach ($directions as $direction) {
            for ($i = 1; $i <= 5; $i++) {
                $titre = $this->getRandomTitle($direction->nom, $i);
                $slug = Str::slug($titre) . '-' . Str::random(5);

                Offre::create([
                    'titre' => $titre,
                    'slug' => $slug,
                    'direction_id' => $direction->id,
                    'category_id' => $categories->random()->id,
                    'description' => $this->getRandomDescription(),
                    'type_contrat_id' => $typeContrats->random()->id,
                    'niveau_experience_id' => $niveauxExp->random()->id,
                    'ville_id' => null,
                    'date_publication' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                    'date_limite' => rand(0, 1) ? now()->addDays(rand(15, 60))->format('Y-m-d') : null,
                    'salaire_min' => rand(20000, 40000),
                    'salaire_max' => rand(45000, 80000),
                    'statut' => $this->getRandomStatut(),
                    'missions' => "Mission n°$i pour la direction " . $direction->nom . " : " . $this->getRandomMission(),
                    'profil' => $this->getRandomProfil(),
                    'niveau_etude_id' => null, // optionnel
                    'validated_at' => null,
                    'validated_by' => null,
                ]);
            }
        }

        $this->command->info('Offres de test créées avec succès.');
    }

    private function getRandomTitle($directionNom, $num)
    {
        $titles = [
            'Chef de projet', 'Développeur Full Stack', 'Ingénieur QA',
            'Analyste fonctionnel', 'Responsable marketing', 'Technicien maintenance',
            'Consultant RH', 'Architecte logiciel', 'Data Scientist', 'Responsable commercial'
        ];
        $base = $titles[array_rand($titles)];
        return $base . ' - ' . $directionNom . ' (Test ' . $num . ')';
    }

    private function getRandomDescription()
    {
        $descriptions = [
            "Nous recherchons un(e) collaborateur(trice) dynamique pour rejoindre notre équipe.",
            "Poste à pourvoir immédiatement. Expérience exigée dans le domaine.",
            "Intégrez une équipe passionnée et participez à des projets innovants.",
            "CDI à pourvoir. Salaire attractif, avantages divers.",
            "Vous aimez les défis ? Rejoignez-nous !",
        ];
        return $descriptions[array_rand($descriptions)] . " Détails : " . Str::random(50);
    }

    private function getRandomMission()
    {
        $missions = [
            "Superviser l'équipe projet",
            "Développer de nouvelles fonctionnalités",
            "Assurer le suivi qualité",
            "Rédiger des spécifications techniques",
            "Animer des réunions client",
            "Gérer le planning et les ressources",
            "Optimiser les processus internes",
        ];
        return $missions[array_rand($missions)];
    }

    private function getRandomProfil()
    {
        $profils = [
            "Bac+5 en informatique, 3 ans d'expérience minimum",
            "Master en marketing, bonne connaissance des outils digitaux",
            "Formation technique, rigueur et autonomie",
            "Diplôme d'ingénieur, anglais courant",
            "Expérience en gestion de projet, certification agile appréciée",
        ];
        return $profils[array_rand($profils)];
    }

    private function getRandomStatut()
    {
        $statuses = ['brouillon', 'ouverte', 'fermée'];
        return $statuses[array_rand($statuses)];
    }

    private function createTemporaryCategories()
    {
        $categories = collect();
        $names = ['Informatique', 'Ressources Humaines', 'Finance', 'Marketing', 'Commercial'];
        foreach ($names as $name) {
            $categories->push(Category::create(['nom' => $name]));
        }
        return $categories;
    }

    private function createTemporaryTypeContrats()
    {
        $types = collect();
        $names = ['CDI', 'CDD', 'Stage', 'Freelance'];
        foreach ($names as $name) {
            $types->push(TypeContrat::create(['nom' => $name]));
        }
        return $types;
    }

    private function createTemporaryNiveauxExp()
    {
        $niveaux = collect();
        $names = ['Junior (<2 ans)', 'Confirmé (2-5 ans)', 'Senior (5-10 ans)', 'Expert (>10 ans)'];
        foreach ($names as $name) {
            $niveaux->push(NiveauExperience::create(['nom' => $name]));
        }
        return $niveaux;
    }
}