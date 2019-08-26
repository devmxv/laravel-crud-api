<?php
//---MXV controller agregado usando php artisan

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//---MXV Agrego referencias
use App\Book;
use Validator;

class BookController extends Controller
{
    //
    public function index(){
        $books = Book::all();
        $data = $books->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Books retrieved successfully'
        ];

        return response()->json($response,200);
    }

    //---MXV, guarda un nuevo recurso (registro de libro)
    public function store(Request $request){
        $input = $request->all();

        //---Validación de datos capturados en URL
        $validator = Validator::make($input, [
            'name' => 'required',
            'author' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'data' => 'Validation error',
                'message' => $validator->errors()
            ];
            return response()->json($response,404);
        }

        //---creación del libro por el método existente
        $book = Book::create($input);
        $data = $book->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Book stored successfully'
        ];

        //---Todo OK regreso respuesta 200
        return response()->json($response,200);
    }

    //---Mostrar el recurso especificado
    //---búsqueda por ID del libro
    public function show($id){
        $book = Book::find($id);
        $data = $book->toArray();

        if(is_null($book)){
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Book not found'
            ];
            return response()->json($response, 404);
        }

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Book retrieved successfully'
        ];

        return response()->json($response,200);
    }

    //---Actualizar el recurso especificado, osea el libro
    //---por nombre y autor
    public function update(Request $request, Book $book){
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'author' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'data' => 'Validation Error',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $book->name = $input['name'];
        $book->author = $input['author'];
        $book->save();

        $data = $book->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Book updated!'
        ];

        return response()->json($response, 200);
    }

    //---Eliminar el recurso especificado (libro en URL)
    public function destroy(Book $book){
        $book->delete();
        $data = $book->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Book deleted'
        ];

        return response()->json($response, 200);
    }
}
