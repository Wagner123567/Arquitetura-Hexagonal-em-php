#!/usr/bin/env bash
set -e
MODULE_NAME=$1
if [ -z "$MODULE_NAME" ]; then
  echo "Uso: $0 NomeDoModulo"
  exit 1
fi
# normaliza nome para Class
CLASS_NAME=$(echo "$MODULE_NAME" | sed -e 's/^\([a-z]\)/\U\1/' -e 's/_\(\([a-z]\)\)/\U\1/g')
BASE="src/Modules/$MODULE_NAME"
mkdir -p "$BASE"/{Domain/{Entity,Repository,ValueObject},Application/UseCase,Infrastructure/{Repository,Eloquent,Migrations},Interface/{Http,Views,Routes}}

cat > "$BASE/Domain/Entity/${CLASS_NAME}.php" <<PHP
<?php declare(strict_types=1);
namespace App\Modules\\$MODULE_NAME\\Domain\\Entity;
class ${CLASS_NAME}
{
    public function __construct(private string \$id) {}
    public function id(): string { return \$this->id; }
}
PHP

cat > "$BASE/Domain/Repository/${CLASS_NAME}RepositoryInterface.php" <<PHP
<?php declare(strict_types=1);
namespace App\Modules\\$MODULE_NAME\\Domain\\Repository;
use App\Modules\\$MODULE_NAME\\Domain\\Entity\\${CLASS_NAME};
interface ${CLASS_NAME}RepositoryInterface
{
    public function findById(string \$id): ?${CLASS_NAME};
    public function save(${CLASS_NAME} \$entity): void;
    public function listAll(): array;
}
PHP

cat > "$BASE/Infrastructure/Eloquent/${CLASS_NAME}Model.php" <<PHP
<?php declare(strict_types=1);
namespace App\Modules\\$MODULE_NAME\\Infrastructure\\Eloquent;
use App\\Shared\\Infrastructure\\Eloquent\\Model;
class ${CLASS_NAME}Model extends Model
{
    protected \$table = '${MODULE_NAME}';
    protected \$fillable = [];
}
PHP

cat > "$BASE/Infrastructure/Repository/Eloquent${CLASS_NAME}Repository.php" <<PHP
<?php declare(strict_types=1);
namespace App\Modules\\$MODULE_NAME\\Infrastructure\\Repository;
use App\Modules\\$MODULE_NAME\\Domain\\Entity\\${CLASS_NAME};
use App\Modules\\$MODULE_NAME\\Domain\\Repository\\${CLASS_NAME}RepositoryInterface;
use App\Modules\\$MODULE_NAME\\Infrastructure\\Eloquent\\${CLASS_NAME}Model;
class Eloquent${CLASS_NAME}Repository implements ${CLASS_NAME}RepositoryInterface
{
    public function findById(string \$id): ?${CLASS_NAME}
    {
        \$model = ${CLASS_NAME}Model::find(\$id);
        return \$model ? new ${CLASS_NAME}(\$model->id) : null;
    }
    public function save(${CLASS_NAME} \$entity): void
    {
        ${CLASS_NAME}Model::updateOrCreate(['id' => \$entity->id()]);
    }
    public function listAll(): array
    {
        \$models = ${CLASS_NAME}Model::all();
        \$items = [];
        foreach (\$models as \$m) { \$items[] = new ${CLASS_NAME}(\$m->id); }
        return \$items;
    }
}
PHP

cat > "$BASE/Application/UseCase/Get${CLASS_NAME}UseCase.php" <<PHP
<?php declare(strict_types=1);
namespace App\Modules\\$MODULE_NAME\\Application\\UseCase;
use App\Modules\\$MODULE_NAME\\Domain\\Repository\\${CLASS_NAME}RepositoryInterface;
class Get${CLASS_NAME}UseCase
{
    public function __construct(private ${CLASS_NAME}RepositoryInterface \$repo) {}
    public function execute(string \$id): ?array
    {
        \$e = \$this->repo->findById(\$id);
        return \$e ? ['id' => \$e->id()] : null;
    }
}
PHP

cat > "$BASE/Application/UseCase/List${CLASS_NAME}UseCase.php" <<PHP
<?php declare(strict_types=1);
namespace App\Modules\\$MODULE_NAME\\Application\\UseCase;
use App\Modules\\$MODULE_NAME\\Domain\\Repository\\${CLASS_NAME}RepositoryInterface;
class List${CLASS_NAME}UseCase
{
    public function __construct(private ${CLASS_NAME}RepositoryInterface \$repo) {}
    public function execute(): array
    {
        return array_map(fn(\$e)=>['id'=>\$e->id()], \$this->repo->listAll());
    }
}
PHP

cat > "$BASE/Interface/Http/${CLASS_NAME}Controller.php" <<PHP
<?php declare(strict_types=1);
namespace App\Modules\\$MODULE_NAME\\Interface\\Http;
use App\Modules\\$MODULE_NAME\\Application\\UseCase\\Get${CLASS_NAME}UseCase;
use App\Modules\\$MODULE_NAME\\Application\\UseCase\\List${CLASS_NAME}UseCase;
class ${CLASS_NAME}Controller
{
    public function __construct(
        private Get${CLASS_NAME}UseCase \$get,
        private List${CLASS_NAME}UseCase \$list
    ) {}
    public function get(string \$id): void
    {
        header('Content-Type: application/json');
        echo json_encode(\$this->get->execute(\$id) ?? ['error'=>'not found']);
    }
    public function list(): void
    {
        header('Content-Type: application/json');
        echo json_encode(\$this->list->execute());
    }
}
PHP

cat > "$BASE/Interface/Routes/routes.php" <<PHP
<?php declare(strict_types=1);
use App\Modules\\$MODULE_NAME\\Infrastructure\\Repository\\Eloquent${CLASS_NAME}Repository;
use App\Modules\\$MODULE_NAME\\Application\\UseCase\\Get${CLASS_NAME}UseCase;
use App\Modules\\$MODULE_NAME\\Application\\UseCase\\List${CLASS_NAME}UseCase;
use App\Modules\\$MODULE_NAME\\Interface\\Http\\${CLASS_NAME}Controller;

\$repo = new Eloquent${CLASS_NAME}Repository();
\$controller = new ${CLASS_NAME}Controller(
    new Get${CLASS_NAME}UseCase(\$repo),
    new List${CLASS_NAME}UseCase(\$repo)
);

return [
    ['method'=>'GET','path'=>'/$MODULE_NAME/{id}','handler'=>fn(\$id)=>\$controller->get(\$id)],
    ['method'=>'GET','path'=>'/$MODULE_NAME','handler'=>fn()=>\$controller->list()],
];
PHP

echo "Módulo $MODULE_NAME criado com scaffold padrão em $BASE"
