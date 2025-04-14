import React from 'react';
import { Link, useForm } from '@inertiajs/react';
import CustomHeader from '@/Layouts/CustomHeader';
import {
    ChakraProvider,
    defaultSystem,
    Text,
    Box,
    HStack,
    Button,
    Input,
    Stack,
} from '@chakra-ui/react';

const Edit = ({m_hospital}) => {
    // Inertiaのformヘルパー関数(useForm)を使用して、送信内容の状態を管理
    const {data, setData, put, errors} = useForm({
        hospital_name: m_hospital?.hospital_name || '',
    });

    // 入力フォームで入力があった際の処理
    const handleChange = (e) => {
        setData({...data, [e.target.name]: e.target.value });
        console.log(data);
    }

    // 送信ボタンが押された際の処理
    const handleSubmit = (e) => {
        e.preventDefault();
        put(`/m_hospitals/edit/${m_hospital.id}`, data);
    }

    // 実際のコンポーネント
    return (
        <ChakraProvider value={defaultSystem}>

            <CustomHeader />

            {/* メイン */}
            <Box className="main" width="80%" m="auto" bg='white' marginTop="20px" p="6" boxShadow='md'>
                <Box textAlign="center" mb="6">
                    <Text fontSize="25px" mb="2">病院マスタ編集フォーム</Text>
                    <Text>対象の病院マスタを更新します。</Text>
                </Box>

                <form onSubmit={handleSubmit}>
                    <Stack gap="4" w="full">
                        <Text>病院名</Text>
                        <Input
                            placeholder="必須入力です"
                            type="text"
                            id="hospital_name"
                            name='hospital_name'
                            value={data.hospital_name}
                            onChange={handleChange}
                        />
                        <Text color="red.500">{errors.hospital_name}</Text>
                    </Stack>
                    <HStack display="flex" justifyContent="center" gap="4" p="0.5rem" m="6">
                        <Button as={Link} href={`/m_hospitals`} color="white" bg="gray.500" size="lg" p="5" width='30%'>戻る</Button>
                        <Button type='submit' color='white' bg="orange.500" size="lg" p="5" width="30%">更新</Button>
                    </HStack>
                </form>

            </Box>
        </ChakraProvider>
    );

}

export default Edit;
