<?php
namespace Hideyo\Backend\Repositories;

interface NewsRepositoryInterface
{

    public function create(array $attributes);

    public function updateById(array $attributes, $id);
    
    public function selectAll();

    public function selectAllByBlogParentId($productParentId);
    
    public function find($id);

    public function selectOneBySlug($shopId, $slug);

    public function selectOneById($shopId, $id);

    public function selectAllByBlogCategoryId($productCategoryId);
    
    public function getModel();

    function selectHomepageBlog($limit);

    function selectByLimitAndOrderBy($shopId, $limit, $orderBy);
}
