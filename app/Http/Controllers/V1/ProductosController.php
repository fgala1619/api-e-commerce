<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if($token != '')
            $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Listamos todos los productos
        return Producto::get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre', 'precio', 'stock', 'categoria', 'sku');

        $validator = Validator::make($data, [
            'nombre' => 'required',
            'precio' => 'required',
            'stock' => 'required',
            'categoria' => 'required',
            'sku' => 'required',
        ]);

        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Creamos el producto en la BD

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria' => $request->categoria,
            'sku' => $request->sku,
        ]);

        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Producto creado',
            'data' => $producto
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el producto
        $producto = Producto::find($id);

        //Si el producto no existe devolvemos error no encontrado
        if (!$producto) {
            return response()->json([
                'message' => 'Producto not found.'
            ], 404);
        }

        //Si hay producto lo devolvemos
        return $producto;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validación de datos
        $data = $request->only('nombre', 'precio', 'stock', 'categoria', 'sku');

        $validator = Validator::make($data, [
            'nombre' => 'required',
            'precio' => 'required',
            'stock' => 'required',
            'categoria' => 'required',
            'sku' => 'required',
        ]);

        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Buscamos el producto
        $producto = Producto::findOrfail($id);

        //Actualizamos el producto.
        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria' => $request->categoria,
            'sku' => $request->sku,
        ]);

        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Producto updated successfully',
            'data' => $producto
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el producto
        $producto = Producto::findOrfail($id);

        //Eliminamos el producto
        $producto->delete();

        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Producto deleted successfully'
        ], Response::HTTP_OK);
    }

    public function busqueda(Request $request)
    {
        $input = $request->all();

        $productos = Producto::where( function ($query) use ($input) {

            if (isset($input['nombre']))
            {
                $query->where('nombre', 'LIKE', '%'. $input['nombre']. '%');
            }
            if (isset($input['precio']))
            {
                $query->where('precio', 'LIKE', '%'. $input['precio']. '%');
            }
            if (isset($input['sku']))
            {
                $query->where('sku', 'LIKE', '%'. $input['sku']. '%');
            }
            if (isset($input['stock']))
            {
                $query->where('stock', 'LIKE', '%'. $input['stock']. '%');
            }
            if (isset($input['categoria']))
            {
                $query->where('categoria', 'LIKE', '%'. $input['categoria']. '%');
            }
        })->paginate(10);


        return response()->json([
            'message' => 'Datos del producto',
            'data' => $productos
        ], Response::HTTP_OK);
    }

    public function cantResultadosBusqueda(Request $request)
    {
        $input = $request->all();

        $productos = Producto::where( function ($query) use ($input) {

            if (isset($input['nombre']))
            {
                $query->where('nombre', 'LIKE', '%'. $input['nombre']. '%');
            }
            if (isset($input['precio']))
            {
                $query->where('precio', 'LIKE', '%'. $input['precio']. '%');
            }
            if (isset($input['sku']))
            {
                $query->where('sku', 'LIKE', '%'. $input['sku']. '%');
            }
            if (isset($input['stock']))
            {
                $query->where('stock', 'LIKE', '%'. $input['stock']. '%');
            }
            if (isset($input['categoria']))
            {
                $query->where('categoria', 'LIKE', '%'. $input['categoria']. '%');
            }
        })->paginate(10);

        return count($productos);

    }

    public function vender(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            //Bucamos el producto
            $producto = Producto::find($id);

            //Si el producto no existe devolvemos error no encontrado
            if (!$producto) {
                return response()->json([
                    'message' => 'Producto not found.'
                ], 404);
            }

            $cant = 1;

            if ($producto->stock <=0)
            {
                return response()->json(['message'  =>  'No hay existencias del producto']);
            }

            $producto->ganancia_total = $cant * $producto->precio;
            $producto->vendido= true;
            $producto->stock = $producto->stock - $cant;

            $producto->update([
                'stock' => $producto->stock,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message'  =>  'Error']);
        }

        return response()->json(['message'  =>  'Success']);
    }

    public function listaArticulosVendidos()
    {
          $productos = Producto::get();

          $lista_vendidos = [];

          foreach ($productos as $item)
          {
              if ($item->vendido == true)
              {
                  $lista_vendidos[] = $item;
              }
          }

        return response()->json([
            'message' => 'Lista de Vendidos',
            'data' => $lista_vendidos
        ], Response::HTTP_OK);
    }

    public function gananciaTotal()
    {
        $productos = Producto::get();

        $ganacia_total = 0;

        foreach ($productos as $item)
        {
            $ganacia_total += $item->ganancia_total;
        }

        return response()->json([
            'message' => 'Ganancia Total',
            'valor' => $ganacia_total
        ], Response::HTTP_OK);
    }

    public function articulosSinStock()
    {
        $productos = Producto::get();

        $lista_sin_stock = [];

        foreach ($productos as $item)
        {
            if ($item->stock == 0)
            {
                $lista_sin_stock[] = $item;
            }
        }

        return response()->json([
            'message' => 'Lista de Articulos sin Stock',
            'data' => $lista_sin_stock
        ], Response::HTTP_OK);
    }

}
