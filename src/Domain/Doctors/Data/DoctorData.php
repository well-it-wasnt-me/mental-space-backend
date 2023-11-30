<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Doctors\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class DoctorData
{
    public ?string $doc_name = null;

    public ?string $doc_surname = null;

    public ?string $doc_rag_soc = null;

    public ?string $doc_tel = null;

    public ?string $doc_photo = null;

    public ?int $doc_hourlyrate = null;

    public ?string $doc_address = null;

    public ?string $doc_paypal = null;

    public ?string $doc_piva = null;


    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [])
    {
        $reader = new ArrayReader($data);

        $this->doc_name = $reader->findString('doc_name');
        $this->doc_surname = $reader->findString('doc_surname');
        $this->doc_rag_soc = $reader->findString('doc_rag_soc');
        $this->doc_tel = $reader->findString('doc_tel');
        $this->doc_photo = $reader->findString('doc_photo');
        $this->doc_hourlyrate = $reader->findInt('doc_hourlyrate');
        $this->doc_address = $reader->findString('doc_address');
        $this->doc_paypal = $reader->findString('doc_paypal');
        $this->doc_piva = $reader->findString('doc_piva');
    }
}
