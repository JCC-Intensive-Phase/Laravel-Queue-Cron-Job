import React,{useState} from 'react'
import { Head, Link } from '@inertiajs/inertia-react'
import Navbar from '../components/Navbar'
import axios from 'axios'

const AddProduct = ({auth}) =>{
    const [productName,setProductName] = useState('')
    const [productPrice,setProductPrice] = useState(0)
    const [image,setImage] = useState('')
    const send = () =>{
        const data = new FormData()
        data.append('product_name',productName)
        data.append('product_price',productPrice)
        data.append('image',image)
        // console.log(data)
        if(productName !== '' && productPrice !== 0 && image !== ''){
            console.log(data)
            axios({
                method: "post",
                url: "/api/product",
                data: data,
                headers: { "Content-Type": "multipart/form-data" },
                })
                .then(data=>{
                    alert('Product ditambahkan')
                    setProductName('')
                    setProductPrice(0)
                    setImage('')
                })
                .catch(data=>console.log(data))

        }else{
            alert('Mohon Lengkapi Data')
        }
    }
    return(
        <>
            <Navbar auth={auth}/>
            <div className='container mt-5  bg-light px-3 mx-auto' style={{width:'500px'}}>
                <h1 className='text-center'>Tambah Produk</h1>
                <div className='form-group mt-2'>
                    <label
                        htmlFor='product_name'>
                        Nama Produk
                    </label>
                    <input
                        type='text'
                        className='form-control'
                        placeholder='Masukan Nama Produk'
                        id='product_name'
                        value={productName}
                        onChange={(e)=>setProductName(e.target.value)}
                    />
                </div>
                <div className='form-group mt-2'>
                    <label
                        htmlFor='product_price'>
                        Harga Produk
                    </label>
                    <input
                        type='number'
                        className='form-control'
                        placeholder='Masukan Harga Produk'
                        id='product_price'
                        value={productPrice}
                        onChange={(e)=>{
                            setProductPrice(e.target.value)

                        }}
                    />
                </div>
                <div className='form-group mt-2'>
                    <label
                        htmlFor='image'>
                        Jumlah Produk
                    </label>
                    <input
                        type='file'
                        className='form-control'
                        placeholder='Masukan Gambar Produk'
                        id='image'
                        // value={image}
                        onChange={(e)=>{
                            setImage(e.target.files[0])
                        }}
                    />
                </div>

                <button
                    className="btn btn-primary mt-3"
                    onClick={()=>send()}
                    >
                    Beli
                </button>
            </div>
        </>
    )
}
export default AddProduct
