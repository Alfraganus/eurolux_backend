<?php

namespace common\modules\publication\actions;

use common\modules\publication\models\Publication;
use common\modules\publication\services\PublicationService;
use Exception;
use Yii;
use common\modules\auth\services\AuthService;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\base\Action;
use yii\web\UploadedFile;

/**
 * @OA\Post(
 *     path="/publication/api/create",
 *     tags={"publication"},
 *     operationId="publication-create",
 *   security={
 *     {"bearerAuth": {}}
 *   },
 *      @OA\Parameter(
 *          name="category",
 *          description="array of category numbers",
 *          in="query",
 *          @OA\Schema(
 *              type="array",
 *              @OA\Items( type="enum", enum={1,2,3,4,5,6,7,8,9} ),
 *          ),
 *          style="form"
 *      ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *           mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 @OA\Property(property="category_id",type="integer",description="category_id"),
 *                 @OA\Property(property="sub_category_id",type="integer",description="sub_category_id"),
 *                 @OA\Property(property="link_video",type="string",description="255 max"),
 *                 @OA\Property(property="title",type="string",description="title"),
 *                 @OA\Property(property="description",type="string",description="description"),
 *                 @OA\Property(property="price",type="float",description="decimal"),
 *                 @OA\Property(property="location",type="string"),
 *                 @OA\Property(property="latitude",type="float"),
 *                 @OA\Property(property="longitude",type="float"),
 *                 @OA\Property(property="tariff_id",type="integer"),
 *                 @OA\Property(property="is_mutually_surcharged",type="integer"),
 *               @OA\Property(property="is_active",type="integer"),
 *
 *           @OA\Property(
 *           property="exchange_category",
 *           type="array",
 *           @OA\Items(
 *                  type="object",
 *                  format="query",
 *                  @OA\Property(property="category_id", type="integer",description="integer" ),
 *                  @OA\Property(property="sub_category_id", type="integer",),
 *                  @OA\Property(property="reaction_type", type="integer",),
 *                    ),
 *                   ),
 *      @OA\Property(
 *           property="images",
 *           type="array",
 *         description="Изображения",
 *           @OA\Items(
 *                  @OA\Property(property="value",type="string" ),
 *                    ),
 *                   ),
 *             )
 *          )
 *     ),
 *
 *     @OA\Response(
 *          response=200,
 *          description="OK",
 *          @OA\JsonContent(
 *             @OA\Schema(type="boolean")
 *          )
 *     ),
 *     @OA\Response(
 *          response=400,
 *          description="Неправильный запрос"
 *     )
 * )
 */
class CreateAction extends Action
{
    private $model;
    private $publicationService;

    public function __construct($id, Controller $controller, PublicationService $service, Publication $publication, $config = [])
    {
        $this->model = $publication;
        $this->publicationService = $service;
        parent::__construct($id, $controller, $config);
    }


    public function run()
    {
        $post = Yii::$app->request->post();
        $responseMessage = Yii::$app->apiResponse;

        if ($this->model->load($post, '') && $this->model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $this->model->setAttributes($this->model->getAttributes());
                $this->model->user_id = Yii::$app->user->id;
                $this->model->save();

                if (!empty($post['exchange_category'])) {
                    $this->publicationService->fillExchangeCategory($post['exchange_category'], $this->model->id);
                }

                if (!empty($_FILES['images'])) {
                    $this->publicationService->fillImages(
                        UploadedFile::getInstancesByName("images"),
                        $this->model->id
                    );
                }
                if (!empty($post['tags'])) {
                    $this->publicationService->fillTags($post['tags'], $this->model->id);
                }
                $transaction->commit();

                return $responseMessage->respond(
                    'Success',
                    'Publication has been successfully created!',
                    ['publication' => $this->model]
                );

            } catch (Exception $e) {
                /*shu yerda tepadagi model kiritilmagan maluimotni ochirib tashlasahim kerak*/
                $transaction->rollBack();
                throw new BadRequestHttpException($e->getMessage(), 0, $e);
            }

        } else {
            return $responseMessage->respond('Fail', '', '', $this->model->errors, 400);
        }


    }
}
