import React,{useState, useEffect} from 'react'
import { Head, Link } from '@inertiajs/inertia-react'
import Navbar from '../components/Navbar'
import axios from 'axios'



const ShowTransaction = ({auth}) =>{
    const [data,setData] = useState([])
    useEffect(() => {
        axios.get(`/api/transaction/${auth.id}`)
            .then(data=>setData(data.data.data))
            .catch(error=>console.log(error))
        return () => {
            setData([])
        }
    }, [])
    return(
        <>
            <Navbar auth={auth}/>
            <div className='container mt-5  '>
                <h1>Semua Transaksi Anda</h1>
                <table className="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga Produk</th>
                            <th scope="col">Jumlah Produk</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.map((data,index)=>{
                            return(
                                <tr key={data.id}>
                                    <th scope="row">{index+1}</th>
                                    <td>{data.product_name}</td>
                                    <td>{data.product_price}</td>
                                    <td>{data.product_amount}</td>
                                    <td>{data.total}</td>
                                    <td>{data.status}</td>
                                    <td>
                                        {data.status === 'created' ?

                                            <button onClick={()=>{
                                                axios.put(`/api/transaction/${data.id}`,{user_id:auth.id})
                                                .then(data=>setData(data.data.data))
                                            }} className='btn btn-success'>Bayar</button>
                                            :
                                            ''
                                        }
                                        {data.status === 'process' ?
                                            'Sudah Bayar':''
                                        }
                                        {data.status === 'failed' ?
                                            'Transaksi Gagal':''
                                        }
                                    </td>
                                </tr>

                            )
                        })}
                    </tbody>
                </table>
            </div>
        </>
    )
}
export default ShowTransaction
