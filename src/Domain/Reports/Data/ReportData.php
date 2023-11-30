<?php

namespace App\Domain\Reports\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class ReportData
{
    public ?int $id = null;

    public ?string $photo = null;

    public ?int $user_id = null;

    public ?string $direction = null;

    public ?float $lon = null;

    public ?float $lat = null;

    public ?int $status = null;

    public ?string $notes = null;

    public ?int $report_type = null;

    public ?string $created_at = null;

    public ?string $updated_at = null;

    public ?string $full_addr = null;

    public ?string $city = null;

    public ?string $county = null;


    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [])
    {
        $reader = new ArrayReader($data);

        $this->id = $reader->findInt('id');
        $this->photo = $reader->findString('photo');
        $this->user_id = $reader->findInt('user_id');
        $this->direction = $reader->findString('direction');
        $this->lon = $reader->findFloat('lon');
        $this->lat = $reader->findFloat('lat');
        $this->status = $reader->findInt('status');
        $this->notes = $reader->findString('notes');
        $this->report_type = $reader->findInt('report_type');
        $this->created_at = $reader->findChronos('created_at');
        $this->updated_at = $reader->findChronos('updated_at');
        $this->full_addr = $reader->findString('full_addr');
        $this->city = $reader->findString('city');
        $this->county = $reader->findString('county');
    }
}