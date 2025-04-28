@extends('errors.layout')

@section('title', __('Terlalu Banyak Permintaan'))
@section('code', '429')
@section('message', __('Maaf, Anda telah melakukan terlalu banyak permintaan. Silakan coba lagi nanti.'))