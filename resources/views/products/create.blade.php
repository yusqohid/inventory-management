@extends('layouts.app')

@section('content')
<div x-data="{ showCategoryModal: false, showSupplierModal: false }">
    <x-common.page-breadcrumb pageTitle="Add New Product" />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">{{ $value }}</x-ui.alert>
        @endsession

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <form action="{{ route('products.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama Produk --}}
                    <div class="col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Product Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 dark:border-gray-700 dark:text-white">
                    </div>

                    {{-- Category dengan Tombol Tambah --}}
                    <div>
                        <div class="flex justify-between mb-1.5">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Category</label>
                            <button type="button" @click="showCategoryModal = true" class="text-xs text-blue-600 hover:underline">+ New Category</button>
                        </div>
                        <select name="category_id" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Supplier dengan Tombol Tambah --}}
                    <div>
                        <div class="flex justify-between mb-1.5">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Supplier</label>
                            <button type="button" @click="showSupplierModal = true" class="text-xs text-blue-600 hover:underline">+ New Supplier</button>
                        </div>
                        <select name="supplier_id" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sisanya sama seperti input sebelumnya (SKU, Price, dll) --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 dark:border-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Sale Price</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price') }}" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 dark:border-gray-700 dark:text-white">
                    </div>
                    {{-- ... Tambahkan field lainnya sesuai fillable ... --}}

                </div>

                <div class="mt-6 flex justify-end">
                    <x-ui.button type="submit" class="px-10">Save Product</x-ui.button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showCategoryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div class="w-full max-w-md rounded-xl bg-white p-6 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-bold dark:text-white">Add New Category</h3>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm dark:text-gray-400">Category Name</label>
                        <input type="text" name="name" required class="w-full rounded-lg border border-gray-300 p-2 dark:bg-gray-800 dark:text-white">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showCategoryModal = false" class="text-sm text-gray-500">Cancel</button>
                    <x-ui.button type="submit">Save Category</x-ui.button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showSupplierModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div class="w-full max-w-lg rounded-xl bg-white p-6 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-bold dark:text-white">Add New Supplier</h3>
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm dark:text-gray-400">Supplier Name</label>
                        <input type="text" name="name" required class="w-full rounded-lg border border-gray-300 p-2 dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm dark:text-gray-400">Contact Person</label>
                        <input type="text" name="contact_person" required class="w-full rounded-lg border border-gray-300 p-2 dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm dark:text-gray-400">Phone</label>
                        <input type="text" name="phone" required class="w-full rounded-lg border border-gray-300 p-2 dark:bg-gray-800 dark:text-white">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showSupplierModal = false" class="text-sm text-gray-500">Cancel</button>
                    <x-ui.button type="submit">Save Supplier</x-ui.button>
                </div>
            </form>
        </div>
    </div>
</div>

<style> [x-cloak] { display: none !important; } </style>
@endsection
