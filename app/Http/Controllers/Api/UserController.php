<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\MeResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OnboardResource;
use App\Http\Requests\User\OnboardingDocument;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Services\Api\User\{OnboardingAddressService, OnboardingBankService, OnboardingCompanyService, UserService};
use App\Http\Resources\{OnboardingAddressResource, OnboardingBankResource, OnboardingCompanyResource, UserResource};
use App\Http\Requests\{CreateOnboardingAddress, CreateOnboardingBank, CreateOnboardingCompany, CreateUserRequest, UpdateUserRequest};

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(
            $this->userService->index()
        );
    }

    public function store(CreateUserRequest $request): UserResource
    {
        return new UserResource(
            $this->userService->store($request->validated())
        );
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return new UserResource(
            $this->userService->update($request->validated(), $user)
        );
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userService->delete($user);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws Throwable
     */
    public function onboardingAddress(CreateOnboardingAddress $request): OnboardingAddressResource
    {
        return new OnboardingAddressResource(
            (new OnboardingAddressService())->store($request->validated())
        );
    }

    /**
     * @throws Throwable
     */
    public function onboardingBank(CreateOnboardingBank $request): OnboardingBankResource
    {
        return new OnboardingBankResource(
            (new OnboardingBankService())->store($request->validated())
        );
    }

    /**
     * @throws Throwable
     */
    public function onboardingCompany(CreateOnboardingCompany $request): OnboardingCompanyResource
    {
        return new OnboardingCompanyResource(
            (new OnboardingCompanyService())->store($request->validated())
        );
    }

    public function onboardingDocument(OnboardingDocument $request)
    {
        $document = $this->userService->storeOnboardingDocument($request->validated());

        return response()->json(['status' => $document]);
    }
    
    public function me()
    {
        return new MeResource(Auth::user());
    }

    public function onboarding()
    {
        return new OnboardResource(Auth::user());
    }
}


