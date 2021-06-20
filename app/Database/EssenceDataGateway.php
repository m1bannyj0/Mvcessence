<?php
namespace EssenceList\Database;

use EssenceList\Entities\Essence;

class EssenceDataGateway
{
    private $pdo;

    // Getting pdo object to work with
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertEssence(Essence $essence)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO essences(first_name, surname, gender, group_number, 
                                            email, exam_score, birth_year, residence)
                       VALUES (:name, :sname, :gender, :groupnum, :email, :examscore, :byear, :residence)"
        );
        $statement->execute(array(
           "name" => $essence->getName(),
           "sname" => $essence->getSurname(),
           "gender" => $essence->getGender(),
           "groupnum" => $essence->getGroupNumber(),
           "email" => $essence->getEmail(),
           "examscore" => $essence->getExamScore(),
           "byear" => $essence->getBirthYear(),
            "residence" => $essence->getResidence()
        ));
    }

    public function getEssenceByEmail(string $email)
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM essences WHERE email=?"
        );
        $statement->bindParam(1, $email, \PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        return $row;
    }
}