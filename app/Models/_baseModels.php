<?php
namespace App\Models;

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 * @OA\Info(
 *   title="BookService",
 *   version="1.0.0",
 *   @OA\Contact(
 *     email="bookservice-admin@unpri.edu.id"
 *   )
 * )
 * @OA\Schema (
 *   schema="data-pagination",
 *   type="object",
 *   @OA\Property(property="current_page", type="integer"),
 *   @OA\Property(property="first_page_url", type="string"),
 *   @OA\Property(property="from", type="integer"),
 *   @OA\Property(property="last_page", type="integer"),
 *   @OA\Property(property="last_page_url", type="string"),
 *   @OA\Property(property="links", type="array",
 *      @OA\Items(
 *        @OA\Property(property="url", type="string"),
 *        @OA\Property(property="lable", type="string"),
 *        @OA\Property(property="active", type="boolean")
 *      )
 *   ),
 *   @OA\Property(property="next_page_url", type="string"),
 *   @OA\Property(property="path", type="string"),
 *   @OA\Property(property="per_page", type="integer"),
 *   @OA\Property(property="prev_page_url", type="string"),
 *   @OA\Property(property="to", type="integer"),
 *   @OA\Property(property="total", type="integer")
 * )
 *
 *  @OA\Schema(
 *    schema="data_manipulation_response",
 *    @OA\Property(property="message", type="string", example="Data Operation Success")
 *  )
 *  @OA\Schema(
 *    schema="AutoIncrement",
 *    @OA\Property(property="id", type="int")
 *  )
 *  @OA\Schema(
 *    schema="DataTimeStamp",
 *   @OA\Property(property="created_at", type="datetime", example="2022-12-31 23:59"),
 *   @OA\Property(property="updated_at", type="datetime", example="2022-12-31 23:59")
 * )
 *  @OA\Schema(
 *  schema="ForbiddenResponse",
 *  type="object",
 *  description="Resource cannot be aquired because lack of user rights",
 *  required={"errorMessages"},
 *  @OA\Property(
 *   property="errorMessages",
 *   type="array",
 *   @OA\Items(
 *    @OA\Schema(type="string")
 *   ),
 *   example={"You do not have sufficient rights to perform this operation"},
 *   description="Error messages",
 *  ),
 *  @OA\Property(property="exception", type="string", description="exception class", example="Authentication" ),
 *  @OA\Property(property="source", type="string", example="local", description="source of message"),
 * )
 *
 * @OA\Schema(
 *  schema="ResourceNotFoundResponse",
 *  type="object",
 *  required={"errorMessages"},
 *  @OA\Property(
 *   property="errorMessages",
 *   type="array",
 *   @OA\Items(
 *    @OA\Schema(type="string")
 *   ),
 *   example={"The operation did not complete successfully because target resource does not exist."},
 *   description="Error messages",
 *  ),
 *  @OA\Property(property="exception", type="string", description="exception class", example="DbOperation" ),
 *  @OA\Property(property="source", type="string", example="local", description="source of message"),
 * )
 *
 * @OA\Schema(
 *  schema="ConflictResponse",
 *  type="object",
 *  description="Default response of request operation when target resource already exist.",
 *  required={"errorMessages"},
 *  @OA\Property(
 *    property="errorMessages",
 *    type="array",
 *    @OA\Items(@OA\Schema(type="string")),
 *    example={"The operation did not complete successfully because target resource already exist."},
 *    description="Error messages",
 *  ),
 *  @OA\Property(property="exception", type="string", description="exception class", example="DbOperation" ),
 *  @OA\Property(property="source", type="string", example="local", description="source of message"),
 * )
 *
 * @OA\Schema(
 *  schema="ValidationFailResponse",
 *  type="object",
 *  description="Validation fail",
 *  required={"errorMessages"},
 *  @OA\Property(
 *   property="errorMessages",
 *   type="array",
 *   @OA\Items(@OA\Schema(type="object")),
 *   example={{"zone_name": {"The zone_name field is required"}}}
 *  ),
 *  @OA\Property(property="exception", type="string", description="exception class", example="BusinessRule" ),
 *  @OA\Property(property="source", type="string", example="local", description="source of message"),
 * )
 *
 * @OA\Schema(
 *  schema="InternalErrorResponse",
 *  type="object",
 *  description="Internal error",
 *  required={"errorMessages"},
 *  @OA\Property(
 *   property="errorMessages",
 *   type="array",
 *   @OA\Items(@OA\Schema(type="string")),
 *   example={"Internal server error"},
 *   description="error message"
 *  ),
 *  @OA\Property(property="exception", type="string", example="ZoneController", description="exception class"),
 *  @OA\Property(property="source", type="string", example="ears_api", description="source of message")
 * )


 *
 * */
class _baseModels
{

}
