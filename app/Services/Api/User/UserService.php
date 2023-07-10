<?php

namespace App\Services\Api\User;

use App\Models\User;
use App\Models\Document;
use App\Traits\FilesTrait;
use App\Enums\CurrencyEnum;
use App\Traits\NextCodeTrait;
use App\Enums\DocumentTypeEnum;
use App\Traits\FilesHelperTrait;
use Illuminate\Support\Facades\Auth;
use App\Services\Api\Auth\AuthService;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exceptions\{AddressExistsException, BankAlreadyExists, BankAlreadyExistsException, CompanyExistsException};

class UserService
{
    use NextCodeTrait, FilesTrait;

    public function __construct(private readonly AuthService $authService) {
        
    }

    public function index(): LengthAwarePaginator
    {
        return User::paginate();
    }

    public function store(array $data): User
    {
        $user        = User::query()->create($data);
        $user->token = $this->authService->createApiToken($user);

        return $user;
    }

    public function update(array $data, User $user): User
    {
        $user->update($data);

        return $user;
    }

    public function delete(User $user): bool|null
    {
        return $user->delete();
    }

    public function storeOnboardingDocument($data)
    {
        $user = Auth::user();

        $img = $this->storeFile($data['file']);

        $socialContract = $this->storeFile($data['social_contract']);

        $this->assignFileToUser($socialContract, $user, DocumentTypeEnum::SOCIAL_CONTRACT);

        return $this->checkDocument($img, $user);


    }
}
