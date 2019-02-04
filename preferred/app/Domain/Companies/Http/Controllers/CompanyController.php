<?php

namespace Preferred\Domain\Companies\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Preferred\Domain\Companies\Contracts\CompanyRepository;
use Preferred\Domain\Companies\Entities\Company;
use Preferred\Domain\Companies\Http\Requests\CompanyCreateRequest;
use Preferred\Domain\Companies\Http\Requests\CompanyUpdateRequest;
use Preferred\Domain\Companies\Http\Resources\CompanyResource;
use Preferred\Domain\Users\Http\Resources\CompanyCollection;
use Preferred\Interfaces\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /** @var CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->resourceItem = CompanyResource::class;
        $this->resourceCollection = CompanyCollection::class;
        $this->authorizeResource(Company::class);
    }

    /**
     * List all companies.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cacheTag = 'companies';
        $cacheKey = 'companies:' . auth()->id() . json_encode(request()->all());

        $collection = Cache::tags($cacheTag)->remember($cacheKey, 60, function () {
            return $this->companyRepository->findByFilters();
        });

        return $this->respondWithCollection($collection);
    }

    /**
     * Show a company.
     *
     * @param Company $company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Company $company)
    {
        return $this->respondWithItem($company);
    }

    /**
     * Store a new company.
     *
     * @param CompanyCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CompanyCreateRequest $request)
    {
        $data = $request->only((new Company)->getFillable());

        $company = $this->companyRepository->store($data);

        return $this->respondWithItem($company);
    }

    /**
     * Update a company.
     *
     * @param CompanyUpdateRequest $request
     * @param Company              $company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $data = $request->only((new Company)->getFillable());

        $company = $this->companyRepository->update($company, $data);

        return $this->respondWithItem($company);
    }
}
