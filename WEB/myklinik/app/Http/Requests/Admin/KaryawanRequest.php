<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanRequest extends FormRequest
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function authorize(): bool
    {
        if (!Request::routeIs('adm.*')) {
            return false;
        }
        return Auth::check();
    }

    public function rules(): array
    {
        if (in_array($this->method(), ['DELETE'])) {
            $rules['karyawan_id'] =  'required|max:255';
        } else if(in_array($this->method(),['POST'])){
            $rules['nip'] =  'required|max:255';
            $rules['email'] =  'required|email|unique:users,email';
            $rules['name'] =  'required|max:255';
            $rules['role_id'] =  'required|max:255';
            $rules['sex'] =  'required|max:1';
            $rules['phone'] =  'nullable|max:255';
            $rules['alamat'] =  'nullable|max:255';
        } else {
            $rules['karyawan_id'] =  'required|max:255';
            $rules['nip'] =  'required|max:255';
            $rules['email'] =  'required|email|unique:users,email';
            $rules['name'] =  'required|max:255';
            $rules['role_id'] =  'required|max:255';
            $rules['sex'] =  'required|max:1';
            $rules['phone'] =  'nullable|max:1';
            $rules['alamat'] =  'nullable|max:255';
        }
        return $rules;
    }

    public function messages()
    {
        if (in_array($this->method(), ['DELETE'])) {
            $message = [
                'karyawan_id.required' => "ID tidak ditemukan,silahkan refresh halaman!",
                'karyawan_id.max' => "ID tidak ditemukan,silahkan refresh halaman!",
            ];
        } else if(in_array($this->method(),['POST'])){
            $message = [
                'nip.required' => "NIP harus diisi!",
                'nip.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'email.required' => "Email harus diisi!",
                'email.email' => "Silahkan isi dengan alamat email yang benar!",
                'email.unique' => "Alamat email sudah terdaftar!",
                'name.required' => "Nama Lengkap harus diisi!",
                'name.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'role_id.required' => "Silahkan pilih Role terlebih dahulu!",
                'role_id.max' => "Silahkan pilih Role terlebih dahulu!",
                'sex.required' => "Silahkan pilih Jenis Kelamin terlebih dahulu!",
                'sex.max' => "Silahkan pilih Jenis Kelamin terlebih dahulu!",
                'phone.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'alamat.max' => "Panjang karakter maksimal adalah 255 karakter!",
            ];
        } else{
            $message = [
                'nip.required' => "NIP harus diisi!",
                'nip.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'email.required' => "Email harus diisi!",
                'email.email' => "Silahkan isi dengan alamat email yang benar!",
                'email.unique' => "Alamat email sudah terdaftar!",
                'name.required' => "Nama Lengkap harus diisi!",
                'name.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'role_id.required' => "Silahkan pilih Role terlebih dahulu!",
                'role_id.max' => "Silahkan pilih Role terlebih dahulu!",
                'sex.required' => "Silahkan pilih Jenis Kelamin terlebih dahulu!",
                'sex.max' => "Silahkan pilih Jenis Kelamin terlebih dahulu!",
                'phone.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'alamat.max' => "Panjang karakter maksimal adalah 255 karakter!",
            ];
        }
        return $message;
    }
}