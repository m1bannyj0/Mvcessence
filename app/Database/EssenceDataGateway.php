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
            "INSERT INTO essences(name, surname, gender, group_number, 
                                            email, exam_score, birth_year, residence, hash)
                       VALUES (:name, :sname, :gender, :groupnum, :email, :examscore, :byear, :residence, :hash)"
        );
        $statement->execute(array(
           "name" => $essence->getName(),
           "sname" => $essence->getSurname(),
           "gender" => $essence->getGender(),
           "groupnum" => $essence->getGroupNumber(),
           "email" => $essence->getEmail(),
           "examscore" => $essence->getExamScore(),
           "byear" => $essence->getBirthYear(),
            "residence" => $essence->getResidence(),
            "hash" => $essence->getHash()
        ));
    }

    public function updateEssence(Essence $essence)
    {
        $statement = $this->pdo->prepare(
          "UPDATE essences 
                     SET `name` = :name,
                         `surname` = :sname,
                         `gender` = :gender,
                         `group_number` = :groupnum,
                         `email` = :email,
                         `exam_score` = :examscore,
                         `birth_year` = :byear,
                         `residence` = :residence
                     WHERE `hash` = :hash"
        );
        $statement->execute(array(
            "name" => $essence->getName(),
            "sname" => $essence->getSurname(),
            "gender" => $essence->getGender(),
            "groupnum" => $essence->getGroupNumber(),
            "email" => $essence->getEmail(),
            "examscore" => $essence->getExamScore(),
            "byear" => $essence->getBirthYear(),
            "residence" => $essence->getResidence(),
            "hash" => $essence->getHash()
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

    public function getEssenceByHash(string $hash)
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM essences WHERE hash=?"
        );
        $statement->bindParam(1,$hash,\PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        return $row;
    }
}