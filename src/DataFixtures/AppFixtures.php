<?php

namespace App\DataFixtures;

use App\Entity\Meal;
use App\Entity\Ingredient;
use App\Entity\Instruction;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Fetch data for multiple meals
        $mealIds = [52770, 52771, 52772, 52773, 52774, 52775, 52776, 52777, 52779, 52780, 52781, 52782, 52783, 52784, 52785, 52786, 52787, 52791, 52792, 52793, 52794, 52795, 52796, 52797, 52802, 52811, 52813, 52814, 52815, 52816];

        foreach ($mealIds as $mealId) {
            $data = $this->fetchMealData($mealId);

            $meal = $this->createMeal($data);
            $manager->persist($meal);

            $instructions = $this->createInstructions($data['strInstructions'], $meal);
            foreach ($instructions as $instruction) {
                $manager->persist($instruction);
            }

            $ingredients = $this->createIngredients($data, $meal);
            foreach ($ingredients as $ingredient) {
                $manager->persist($ingredient);
            }
        }

        $manager->flush();
    }

    private function fetchMealData(int $mealId): array
    {
        $url = sprintf('https://www.themealdb.com/api/json/v1/1/lookup.php?i=%d', $mealId);
        $data = file_get_contents($url);

        return json_decode($data, true)['meals'][0];
    }

    private function createMeal(array $data): Meal
    {
        $meal = new Meal();
        $meal
            ->setName($data['strMeal'])
            ->setCategory($data['strCategory'])
            ->setArea($data['strArea'])
            ->setImage($data['strMealThumb']);

        return $meal;
    }

    private function createInstructions(string $instructions, Meal $meal): array
    {
        $instructionArray = explode("\r\n", $instructions);
        $instructionObjects = [];

        foreach ($instructionArray as $key => $instruction) {
            $instructionObject = new Instruction();
            $instructionObject
                ->setDescription($instruction)
                ->setInstructionRank($key + 1)
                ->setMeal($meal);

            $instructionObjects[] = $instructionObject;
        }

        return $instructionObjects;
    }

    private function createIngredients(array $data, Meal $meal): array
    {
        $ingredients = [];

        for ($i = 1; $i <= 12; $i++) {
            $ingredient = new Ingredient();
            $ingredient
                ->setName($data['strIngredient' . $i])
                ->setMeasure($data['strMeasure' . $i])
                ->setMeal($meal);

            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }
}
