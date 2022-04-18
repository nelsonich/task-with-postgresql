@extends('layouts.app')

@section('content')
    <div class="container products">
        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Артикул</th>
                            <th>Название</th>
                            <th>Статус</th>
                            <th>Атрибуты</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $item)
                            <tr class="single-product" data-productid="{{ $item->id }}">
                                <td>{{ $item->article }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    @forelse(json_decode($item->data) as $attr)
                                        {{ $attr->name . ': ' . $attr->value }} <br />
                                    @empty
                                        Нет атрибута!!
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4">Пусто!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 d-flex justify-content-end align-items-start">
                <button id="open-create-dialog">Добавить</button>

                <div class="product-create-dialog hide">
                    <div class="modal-header">
                        <h4>Добавить продукт</h4>
                        <span class="close-modal">&#x2715;</span>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('product.create') }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="article">Артикул</label>
                                <input type="text" class="form-control" id="article" name="article">
                            </div>

                            <div class="form-group mb-2">
                                <label for="name">Название</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="form-group mb-2">
                                <label for="status">Статус</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="available">available</option>
                                    <option value="unavailable">unavailable</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="attributes">Атрибуты</label>

                                <div class="product-attributes"></div>

                                <span class="product-add-attribute">&#x2b; Добавить атрибут</span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mt-2">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="product-view-dialog hide">
                    <div class="modal-header">
                        <h4></h4>

                        <div>
                            <span class="open-edit-dialog">
                                <i class='fas fa-pen'></i>
                            </span>
                            <span class="remove-product">
                                <a href="#">
                                    <i class='fas fa-trash-alt'></i>
                                </a>
                            </span>
                        </div>
                        <span class="close-modal">&#x2715;</span>
                    </div>
                    <div class="modal-body">
                        <div class="row text-white d-flex article"></div>
                        <div class="row text-white d-flex name"></div>
                        <div class="row text-white d-flex status"></div>
                        <div class="row text-white d-flex attributes"></div>
                    </div>
                </div>

                <div class="product-edit-dialog hide">
                    <div class="modal-header">
                        <h4></h4>
                        <span class="close-modal">&#x2715;</span>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="article">Артикул</label>
                                <input type="text" class="form-control" id="article" name="article"
                                    {{ 'admin' !== config('products.role') ? 'readonly' : '' }}>
                            </div>

                            <div class="form-group mb-2">
                                <label for="name">Название</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="form-group mb-2">
                                <label for="status">Статус</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="available">available</option>
                                    <option value="unavailable">unavailable</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="attributes">Атрибуты</label>

                                <div class="product-attributes"></div>

                                <span class="product-add-attribute">&#x2b; Добавить атрибут</span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mt-2">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
