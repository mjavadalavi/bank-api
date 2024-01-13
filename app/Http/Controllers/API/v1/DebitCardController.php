<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DebitCardRequest;
use App\Http\Resources\DebitCardResource;
use App\Models\DebitCard;

class DebitCardController extends Controller
{
    public function index()
    {
        return DebitCardResource::collection(DebitCard::all());
    }

    public function store(DebitCardRequest $request)
    {
        return new DebitCardResource(DebitCard::create($request->validated()));
    }

    public function show(DebitCard $userBankCredit)
    {
        return new DebitCardResource($userBankCredit);
    }

    public function update(DebitCardRequest $request, DebitCard $userBankCredit)
    {
        $userBankCredit->update($request->validated());

        return new DebitCardResource($userBankCredit);
    }

    public function destroy(DebitCard $userBankCredit)
    {
        $userBankCredit->delete();

        return response()->json();
    }
}
