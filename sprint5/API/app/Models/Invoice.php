<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

/** @OA\Schema(
 *     schema="InvoiceRequest",
 *     type="object",
 *     title="InvoiceRequest",
 *     properties={
 *         @OA\Property(property="billing_address", type="string"),
 *         @OA\Property(property="billing_city", type="string"),
 *         @OA\Property(property="billing_country", type="string"),
 *         @OA\Property(property="billing_state", type="string"),
 *         @OA\Property(property="billing_postcode", type="string"),
 *         @OA\Property(property="cart_id", type="string", example="Cash on Delivery")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="InvoiceResponse",
 *     type="object",
 *     title="InvoiceResponse",
 *     properties={
 *         @OA\Property(property="id", type="string", example=1),
 *         @OA\Property(property="invoice_date", type="string", example="2022-10-20 09:49:45"),
 *         @OA\Property(property="invoice_number", type="string", example="INV-2022000002"),
 *         @OA\Property(property="billing_address", type="string"),
 *         @OA\Property(property="billing_city", type="string"),
 *         @OA\Property(property="billing_country", type="string"),
 *         @OA\Property(property="billing_state", type="string"),
 *         @OA\Property(property="billing_postcode", type="string"),
 *         @OA\Property(property="total", type="number"),
 *         @OA\Property(property="status", type="string", example="COMPLETED"),
 *         @OA\Property(property="status_message", type="string", example=""),
 *         @OA\Property(property="invoice_items", type="array", @OA\Items(ref="#/components/schemas/InvoiceLineResponse"))
 *     }
 * )
 */
class Invoice extends BaseModel
{
    use FilterQueryString, HasUlids;

    protected $filters = ['in', 'sort', 'starts_with'];
    protected $table = 'invoices';
    protected $fillable = ['user_id', 'invoice_date', 'invoice_number', 'billing_address', 'billing_city', 'billing_state', 'billing_country', 'billing_postcode', 'total'];
    protected $hidden = ['updated_at', 'document'];

    protected $casts = array(
        "total" => "double"
    );

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoicelines(): HasMany
    {
        return $this->hasMany(Invoiceline::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

}
