<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Modules\Users\Application\UseCase\GetUserUseCase;
use App\Modules\Users\Domain\Entity\User;
use App\Modules\Users\Domain\Repository\UserRepositoryInterface;

class GetUserUseCaseTest extends TestCase
{
    public function testExecuteReturnsUser()
    {
        $repo = $this->createMock(UserRepositoryInterface::class);
        $user = new User('1','a@b.com','A');
        $repo->method('findById')->willReturn($user);
        
        $uc = new GetUserUseCase($repo);
        $result = $uc->execute('1');
        
        $this->assertSame('1', $result['id']);
    }
}
