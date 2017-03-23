<?php
namespace Hideyo\Backend\Repositories;

interface ExtraFieldDefaultValueRepositoryInterface
{

    public function create(array $attributes, $extraFieldId);

    public function updateById(array $attributes, $extraFieldId, $id);
    
    public function selectAll();

    public function selectAllByAllProductsAndProductCategoryId($productCategoryId);
    
    public function find($id);
}
