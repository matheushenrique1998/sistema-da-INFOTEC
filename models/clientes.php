<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/database/DBConexao.php";
class clientes
{
    protected $db;
    protected $table = "cadastro_clentes";

    public function __construct()
    {
        $this->db = DBConexao::getConexao();
    }
    /** 
     * buscar registro unico
     * @param int $id
     * @return cadastro_clente|null
     */
    public function buscar($id_clentes)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id_clentes=:id_clentes";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_clentes", $id_clentes, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "erro ao buscar:" . $e->getMessage();
            return null;
        }
    }

    /** 
     * lista de registro
     * @param int $id
     * @return
     */
    public function listar()
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "erro na preparação da consulta" . $e->getMessage();
        }
    }
    /** 
     * cadastrar usuarios
     * @param array $dados
     * @return bool
     */
    public function cadastrar($dados)
    {
        try {
            $query = "INSERT INTO {$this->table} (id_clentes, nome , email,  senha, cpf, endereco, telefone ) VALUES (:id_clentes, :nome , :email, :senha, :cpf, :endereco, :telefone)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_clentes', $dados['id_clentes']);
            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(': email', $dados[' email']);
            $stmt->bindParam(': senha', $dados[' senha']);
            $stmt->bindParam(':cpf', $dados['cpf']);
            $stmt->bindParam(':endereco', $dados['endereco']);
            $stmt->bindParam(':telefone', $dados['telefone']);
            $stmt->execute();
            $_SESSION['sucesso'] = "clientes realizado com sucesso";
            return true;
        } catch (PDOException $e) {
            echo "Erro ao cadastrar: " . $e->getMessage();
            $_SESSION['erro'] = " erro ao cadastrar cliente";
            return false;
        }
    }

    /** 
     * editar
     * @param int $id
     * @param array $dados
     * @return bool
     */
    public function editar($id_clentes, $dados)
    {
        try {
            $sql = "UPDATE {$this->table} SET  nome = : nome, email = :email,
            senha= :senha, cpf = :cpf, endereco = :endereco , telefone= :telefone WHERE id_clentes = :id_clentes";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(': email', $dados[' email']);
            $stmt->bindParam(': senha', $dados[' senha']);
            $stmt->bindParam(':cpf', $dados['cpf']);
            $stmt->bindParam(':endereco', $dados['endereco']);
            $stmt->bindParam(':telefone', $dados['telefone']);
            $stmt->bindParam('id_clentes', $id_clentes, PDO::PARAM_INT);
            $stmt->execute();
            $_SESSION['sucesso'] = "usuario editado com sucesso";
            return true;
        } catch (PDOException $e) {
            echo "erro na edição de dados:" . $e->getMessage();
            return false;
        }
    }
    //excluir os dados do usuario
    public function excluir($id_clentes)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id_clentes = :id_clentes";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_clentes', $id_clentes, PDO::PARAM_INT);
            $stmt->execute();
            $_SESSION['sucesso'] = "perfil excluido com sucesso!";
            return true;
        } catch (PDOException $e) {
            echo "erro ao excluir dados do clientes:" . $e->getMessage();
            return false;
        }
    }
}
