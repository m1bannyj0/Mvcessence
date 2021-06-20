<?php
namespace EssenceList\Helpers;

use EssenceList\Entities\Essence;

class Util
{
    public function generateHash(int $length = 32)
    {
        if ($length <= 8) {
            $length = 32;
        }
        return bin2hex(random_bytes($length));
    }

    public function createEssence(array $values)
    {
        $essence = new Essence(
            $values["name"],
            $values["surname"],
            $values["group_number"],
            $values["email"],
            $values["exam_score"],
            $values["birth_year"],
            $values["gender"],
            $values["residence"]
        );

        return $essence;
    }
}
