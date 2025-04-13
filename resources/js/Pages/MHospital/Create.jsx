import React from 'react';
import { Link, useForm, router } from '@inertiajs/react';
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


const Create = () => {

    // InertiaのuseFormを使用してフォームデータの状態(State)を管理
    const { data, setData, post, processing, errors } = useForm({
        hospital_name: '',
    });

    // 入力フォームで入力された際の処理
    const handleChange = (e) => {
        console.log('changeイベント発火');
        // Stateの更新変数に、フォームで入力されたinputタグのname属性をプロパティ名にして、valueにinputタグで入力された値をformData(state)にセットして値を更新する
        setData({...data, [e.target.name]: e.target.value });

        console.log(data);
    }

    // 送信ボタンがクリックされた際の処理(submitイベントが発火した際の処理)
    const handleSubmit = (e) => {
        console.log('submitイベント発火');
        // SPAとして動作するReactアプリケーション内で、ページ遷移を伴わない形で処理を実行できるようにする
        e.preventDefault();

        // Inertia.jsのrouterオブジェクトのpostメソッドを使用して、Laravelのルーティング(web.phpで該当するURI)に対して、フォームで入力された値(state)を渡して、Laravel側でのstoreアクションを実行する
        post('/m_hospital_names/store', data);
    }

    return (
        <ChakraProvider value={defaultSystem}>
        <>
            <CustomHeader />

            {/* メイン */}
            <Box className='main' width="80%" m="auto" bg='white' marginTop='20px' p="6" boxShadow='md'>
                <Box maxW="md" m='auto'>
                    <Box textAlign="center" mb="6">
                        <Text fontSize='25px' mb="2">病院マスタ登録フォーム</Text>
                        <Text>新しく病院マスタ情報を登録します。</Text>
                    </Box>

                    <Box as="form" onSubmit={handleSubmit}>
                        <Stack gap="4" w="full">
                            <Text>病院名</Text>
                            <Input
                                placeholder='必須入力です'
                                type='text'
                                id='hospital_name'
                                name='hospital_name'
                                value={data.hospital_name}
                                onChange={handleChange}
                            />
                            <Text color="red.500">{errors.hospital_name}</Text>
                        </Stack>
                        <HStack display="flex" justifyContent="center" gap="4" p="0.5rem" m='6'>
                            <Button as={Link} href={`/m_hospitals`} color='white' bg='gray.500' size='lg' p='5' width='30%'>戻る</Button>
                            <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%' isLoading={processing}>登録</Button>
                        </HStack>
                    </Box>
                </Box>
            </Box>

        </>
        </ChakraProvider>
    );
}

export default Create;
