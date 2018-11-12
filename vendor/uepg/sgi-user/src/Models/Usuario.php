<?php

namespace Uepg\SGIUser\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Usuario extends Model implements AuthenticatableContract,
                                    AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * Retorna o objeto do usuário para salvar na session
     * @return [type] [description]
     */
    public function getAuthIdentifier() {
        return $this->fill($this->attributes);
    }

    /**
     * O nome da role.tabela usada para este modelo.
     *
     * @var string
     */
    protected $table;

    /**
     * O nome do campo de chave primária, deve ser definido quando diferente
     * do padrão do framework que é id
     *
     * @var string
     * @see http://laravel.com/docs/eloquent#basic-usage
     */
    protected $primaryKey = 'id';
    protected $nome;

    /**
     * Atributos para serem escondidos do  modelo JSON form.
     *
     * @var array
     */
    protected $hidden = array();

    /**
     * Define se a tabela possui as colunas updated_at e created_at
     * para serem atualizadas por padrão pelo framework
     * 
     * @var boolean TRUE = possui as tabelas, FALSE = não possui
     */
    public $timestamps = false;

    /**
     * Determina os campos que NÃO podem ser inseridos diretamente de um array
     * 
     * @var array 
     * @see http://laravel.com/docs/eloquent#mass-assignment
     */
    protected $guarded = array('id');
    
    public function __construct(array $attributes = []) {
        
            parent::__construct($attributes);
            
            $this->table = env('DB_USERTABLE', null);
            
            $this->fill($attributes);

    }

}
