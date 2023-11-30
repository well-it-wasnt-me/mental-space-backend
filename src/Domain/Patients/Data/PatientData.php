<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Patients\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class PatientData
{
    public ?string $surname = null;

    public ?string $name = null;

    public ?string $cf = null;

    public ?string $dob = null;

    public ?string $telefono = null;

    public ?string $email = null;

    public ?int $city_id = null;

    public ?string $address = null;

    public ?string $em_nome = null;

    public ?string $em_telefono = null;

    public ?int $height = null;

    public ?int $weight = null;

    public ?array $dsm_id = [];

    public ?array $curr_pharms = null;

    public ?string $relazione = null;

    public ?string $invito = null;


    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [])
    {
        $reader = new ArrayReader($data);

        $this->surname = $reader->findString('surname');
        $this->name = $reader->findString('name');
        $this->cf = $reader->findString('cf');
        $this->dob = $reader->findString('dob');
        $this->telefono = $reader->findString('telefono');
        $this->email = $reader->findString('email');
        $this->address = $reader->findString('address');
        $this->em_nome = $reader->findString('em_nome');
        $this->em_telefono = $reader->findString('em_telefono');
        $this->height = $reader->findInt('height');
        $this->weight = $reader->findInt('weight');
        //$this->dsm_id = $reader->findArray('dsm_id');
        //$this->curr_pharms = $reader->findString('curr_pharms');
        $this->relazione = $reader->findString('relazione');
        $this->invito = $reader->findString('invito');
    }
}
