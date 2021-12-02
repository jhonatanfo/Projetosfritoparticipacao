<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
defined("SSX") or die;

interface SsxModelsInterface 
{	
	/**
	 * Função de armazenamento mais comum nos frameworks
	 * 
	 * @param $values Array contendo os itens que serão salvos no banco de dados
	 * @param $generate_guid[opcional][default true] define se gerado um UUID com 36 caracteres para ser usado no ID
	 * 
	 * @return string
	 */
	public function saveValues($values, $generate_guid);	
	
	/**
	 * Monta a lista de fields de acordo com o que foi informado no array publico $fields
	 * @param string $prefix_table para o caso de estar usando algum tipo de join
	 */
	public function field_string($prefix_table);
	
	/**
	 * Retorna um dado baseado no ID
	 * @param string|int $id
	 */
	public function fill($id);
	
	/**
	 * Conta elementos apartir de uma certa condição do tipo translateQuery
	 * @param array $query
	 */
	public function count($query);
	
	/**
	 * Verifica se o campo já existe
	 * @param string $field
	 */
	public function checkFieldExists($field);
	
	/**
	 * Função simples de criptografia que chama a função padrão MD5 e retorna a string criptografada
	 * @param string $password
	 */
	public function encryptPassword($password);
	
}