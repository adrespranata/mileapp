<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{

    public function index()
    {
        $packages = Package::with(['customerAttribute', 'connote', 'originData', 'destinationData', 'koliData'])->get();
        return response()->json($packages, 200);
    }

    public function store(Request $request)
    {
        // Validasi request JSON
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'customer_code' => 'required|string',
            'transaction_amount' => 'required|integer',
            'transaction_discount' => 'required|integer',
            'transaction_additional_field' => 'nullable',
            'transaction_payment_type' => 'required|integer',
            'transaction_state' => 'required|string',
            'transaction_code' => 'required|string',
            'transaction_order' => 'required|integer',
            'location_id' => 'required|string',
            'transaction_payment_type_name' => 'required|string',
            'transaction_cash_amount' => 'required|int',
            'transaction_cash_change' => 'required|int',
            'connote_id' => 'required|uuid',
            'custom_field' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Ambil data dari JSON request
        $requestData = $request->json()->all();

        // Buat Package
        $package = Package::create($requestData);

        // Buat Customer Attribute
        $customerAttributeData = $requestData['customer_attribute'];
        $package->customerAttribute()->create($customerAttributeData);

        // Buat Connote
        $connoteData = $requestData['connote'];
        $package->connote()->create($connoteData);

        // Buat Origin Data
        $originData = $requestData['origin_data'];
        $package->originData()->create($originData);

        // Buat Destination Data
        $destinationData = $requestData['destination_data'];
        $package->destinationData()->create($destinationData);

        // Buat Koli Data
        $koliData = $requestData['koli_data'];
        foreach ($koliData as $koliDatum) {
            $package->koliData()->create($koliDatum);
        }

        // Buat Custom Field
        $customFieldData = $requestData['custom_field'];
        $package->customField()->create($customFieldData);

        // Buat Current Location
        $currentLocationData = $requestData['currentLocation'];
        $package->currentLocation()->create($currentLocationData);

        return response()->json($package, 201);
    }

    public function update(Request $request, $id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string|unique:packages,transaction_id,' . $id,
            'customer_name' => 'required|string',
            'customer_code' => 'required|string',
            'transaction_amount' => 'required|numeric',
            'transaction_discount' => 'required|numeric',
            'transaction_additional_field' => 'nullable|string',
            'transaction_payment_type' => 'required|string',
            'transaction_state' => 'required|string',
            'transaction_code' => 'required|string',
            'transaction_order' => 'required|integer',
            'location_id' => 'required|string',
            'organization_id' => 'required|integer',
            'created_at' => 'required|date',
            'updated_at' => 'required|date',
            'transaction_payment_type_name' => 'required|string',
            'transaction_cash_amount' => 'required|numeric',
            'transaction_cash_change' => 'required|numeric',
            'customer_attribute' => 'required|array',
            'connote' => 'required|array',
            'origin_data' => 'required|array',
            'destination_data' => 'required|array',
            'koli_data' => 'required|array',
            'custom_field' => 'required|array',
            'currentLocation' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $packageData = $request->all();

        // Update Package
        $package->update($packageData);

        // Update related records
        $package->customerAttribute->update($packageData['customer_attribute']);
        $package->connote->update($packageData['connote']);
        $package->originData->update($packageData['origin_data']);
        $package->destinationData->update($packageData['destination_data']);

        // Delete existing KoliData and create new ones
        $package->koliData()->delete();
        foreach ($packageData['koli_data'] as $koliDatum) {
            $package->koliData()->create($koliDatum);
        }

        $package->customField->update($packageData['custom_field']);
        $package->currentLocation->update($packageData['currentLocation']);

        return response()->json($package, 200);
    }

    public function updatePatch(Request $request, $id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'transaction_id' => 'string|unique:packages,transaction_id,' . $id,
            'customer_name' => 'string',
            'customer_code' => 'string',
            'transaction_amount' => 'numeric',
            'transaction_discount' => 'numeric',
            'transaction_additional_field' => 'string',
            'transaction_payment_type' => 'string',
            'transaction_state' => 'string',
            'transaction_code' => 'string',
            'transaction_order' => 'integer',
            'location_id' => 'string',
            'organization_id' => 'integer',
            'created_at' => 'date',
            'updated_at' => 'date',
            'transaction_payment_type_name' => 'string',
            'transaction_cash_amount' => 'numeric',
            'transaction_cash_change' => 'numeric',
            'customer_attribute' => 'array',
            'connote' => 'array',
            'origin_data' => 'array',
            'destination_data' => 'array',
            'koli_data' => 'array',
            'custom_field' => 'array',
            'currentLocation' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $packageData = $request->all();

        // Update only the provided fields
        $package->fill($packageData);
        $package->save();

        return response()->json($package, 200);
    }

    public function destroy($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $package->delete();

        return response()->json(['message' => 'Data deleted'], 200);
    }
}
