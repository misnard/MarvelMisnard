<?php
namespace Marvel\Model;
/**
 * This class contain all connector to get Api datas
 * Class Marvel_Model_MarvelData
 */
class MarvelDataModel
{
    private $apiClient;
    /**
     * On class construct we initialize Marvel_ApiClient_Model
     * Marvel_Model_MarvelData constructor.
     */
    public function __construct()
    {
        $this->apiClient = new MarvelApiClientModel();
    }

    /**
     * Method called by vue to return current characters collection
     * @return mixed
     */
    public function charactersCollection()
    {
        return $this->apiClient->getCharactersCollection();
    }
}
