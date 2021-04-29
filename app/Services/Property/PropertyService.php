<?php
namespace App\Services\Property;

use App\Http\Resources\Collections\PropertyCollection;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyService
{

    public function getAllProperties(Request $request)
    {
        $properties = Property::where(function($query) use ($request) {

                    if (isset($request->keyword) && $request->has('keyword')) 
                    {
                        $keyword = strtolower($request->keyword);
                        $query->whereRaw('LOWER(name) LIKE ? ', "%{$keyword}%");
                    }
                    
                    if (isset($request->price_min) 
                        && isset($request->price_max) 
                        && $request->has('price_min') 
                        && $request->has('price_max')
                    ) {
                        $query->whereBetween('price', [$request->price_min, $request->price_max]);
                    }
                    
                    if (isset($request->bedrooms) && $request->has('bedrooms')) 
                    {
                        $query->where('bedrooms', $request->bedrooms);
                    }

                    if (isset($request->bathrooms) && $request->has('bathrooms'))
                    {
                        $query->where('bathrooms', $request->bathrooms);
                    }

                    if (isset($request->garages) && $request->has('garages')) 
                    {
                        $query->where('garages', $request->garages);
                    }

                    if (isset($request->storeys) && $request->has('storeys')) 
                    {
                        $query->where('storeys', $request->storeys);
                    }
                }
            )
            ->get();

        if (! $properties) {
            throw new \Exception('Sorry, we are unable to retrieve properties.', 404);
        }

        return (new PropertyCollection($properties));
    }
}

?>
