<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/6
 * Time: 10:33
 */
namespace Commodity\Attribute;

use Commodity\Repository\AttributeRepository;

class Info
{
    /**
     * @var AttributeRepository
     */
    protected $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param array $data
     *         name
     *         cate_id
     *         show   1 ? 0
     *         sort
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->attributeRepository->add($data);
    }

    /**
     * 修改名称
     *
     * @param $id
     * @param $name
     *
     * @return bool
     */
    public function updateName(int $id, string $name)
    {
        return $this->attributeRepository->update($id, ['name' => $name]);
    }

    /**
     * 删除分类
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->attributeRepository->delete($id);
    }

    /**
     * 分类ID
     *
     * @param int $cateId
     *
     * @return bool
     */
    public function getByCate(int $cateId)
    {
        return $this->attributeRepository->searchCateId($cateId);
    }
}