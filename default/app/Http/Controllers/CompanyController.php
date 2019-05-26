<?php

namespace App\Http\Controllers;

use App\Contracts\CompanyRepository;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Support\Facades\Cache;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
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

        $collection = Cache::tags($cacheTag)->remember($cacheKey, 3600, function () {
            return $this->companyRepository->findByFilters();
        });

        return $this->respondWithCollection($collection);
    }

    /**
     * Show a company.
     *
     * @param Company $company
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CompanyCreateRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));

        $company = $this->companyRepository->store($data);

        return $this->respondWithItem($company);
    }

    /**
     * Update a company.
     *
     * @param CompanyUpdateRequest $request
     * @param Company              $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $data = $request->only(array_keys($request->rules()));

        $company = $this->companyRepository->update($company, $data);

        return $this->respondWithItem($company);
    }
}
