<?php

namespace App\Domain\Reports\Service;

use App\Domain\Reports\Repository\ReportRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class ReportValidator
{
    private ReportRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param ReportRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(ReportRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }


    /**
     * Validate new report.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateReport(array $data): void
    {
        $validator = $this->createValidator();

        $validationResult = $this->validationFactory->createValidationResult(
            $validator->validate($data)
        );

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    /**
     * Create validator.
     *
     * @return Validator The validator
     */
    private function createValidator(): Validator
    {
        $validator = $this->validationFactory->createValidator();

        return $validator
            ->notEmptyString('photo', 'Input required')
            ->integer('user_id', 'Input required')
            ->notEmptyString('lon', 'Missing Longitude')
            ->notEmptyString('lat', "Missing latitude")
            ->integer('report_type', "Missing Report type")
            ->notEmptyString('full_addr', "Input required")
            ->notEmptyString('city', "Input required")
            ->notEmptyString('county', "Input required")
            ->notEmptyString('report_type', "Input required");
    }
}