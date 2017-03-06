<?php
namespace Hideyo\Repositories;

interface AttributeGroupRepositoryInterface
{

    public function rules($id = false);

    public function create(array $attributes);

    public function updateById(array $attributes, $id);
    
    public function updateEntity(array $attributes = array());

    public function destroy($id);

    public function selectAllByAllProductsAndProductCategoryId($productCategoryId);

    public function selectAll();
    
    public function find($id);
}
