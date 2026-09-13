<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Core\Infrastructure\Database;
use App\Modules\Users\Infrastructure\Repository\EloquentUserRepository;
use App\Modules\Users\Domain\Entity\User;

class EloquentUserRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        Database::boot();
        // limpa e recria tabela
        \Illuminate\Database\Capsule\Manager::schema()->dropIfExists('users');
        \Illuminate\Database\Capsule\Manager::schema()->create('users', function ($t) {
            $t->string('id')->primary();
            $t->string('email');
            $t->string('name');
        });
    }

    public function testSaveAndFind()
    {
        $repo = new EloquentUserRepository();
        $user = new User('u1','test@ex.com','Test');
        $repo->save($user);
        $found = $repo->findById('u1');
        $this->assertNotNull($found);
        $this->assertSame('test@ex.com', $found->email());
    }
}
