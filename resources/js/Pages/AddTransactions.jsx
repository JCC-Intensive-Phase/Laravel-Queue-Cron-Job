import React,{useState} from 'react'
import { Head, Link } from '@inertiajs/inertia-react'
import Navbar from '../components/Navbar'
import axios from 'axios'

const AddTransaction = ({auth}) =>{
    const [productName,setProductName] = useState('')
    const [productPrice,setProductPrice] = useState(0)
    const [productAmount,setProductAmount] = useState(0)
    const [total,setTotal] = useState(0)
    const send = () =>{
        const data = {
            product_name:productName,
            product_price:productPrice,
            product_amount:productAmount,
            total:total,
            user_id:auth.id
        }
        if(productName !== '' && productPrice !== 0 && productAmount !== 0){
            console.log(data)
            axios.post('/api/transaction',data)
                .then(data=>{
                    alert('Transaksi Berhasil Dibuat. Harap bayar sebelum 1 jam untuk kami proses')
                    setProductName('')
                    setProductPrice(0)
                    setProductAmount(0)
                })
                .catch(error=>console.log(error))

        }else{
            alert('Mohon Lengkapi Data')
        }
    }
    setTimeout(()=>{
        setTotal(productAmount * productPrice)
        console.log('berubah')
    },100)
    return(
        <>
            <Navbar auth={auth}/>
            <div className='container mt-5  bg-light px-3 mx-auto' style={{width:'500px'}}>
                <h1 className='text-center'>Tambah Transaksi</h1>
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
                        htmlFor='product_amount'>
                        Jumlah Produk
                    </label>
                    <input
                        type='number'
                        className='form-control'
                        placeholder='Masukan Jumlah Produk'
                        id='product_amount'
                        value={productAmount}
                        onChange={(e)=>{
                            setProductAmount(e.target.value)

                        }}
                    />
                </div>
                <h4 className='mt-5'>Total: Rp {total}</h4>

                <button
                    className="btn btn-primary"
                    onClick={()=>send()}
                    >
                    Beli
                </button>
            </div>
        </>
    )
}
export default AddTransaction
