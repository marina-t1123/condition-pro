import { Box, ChakraProvider, defaultSystem, Stack, Text, NativeSelect, Input, HStack, Button } from '@chakra-ui/react';
import { useForm, Link } from '@inertiajs/react';
import CustomHeader from '@/Layouts/CustomHeader';
import React from 'react';


const Create = ({m_events}) => {
    //  InsertiaのuseFromを使用して、フォームデータのステータス管理や送信処理を行えるようにする
    const {data, setData, post, errors} = useForm({
        m_event_id: '',
        event_position_name: ''
    });
    // 入力フォームで入力した際の、フォームの値の保持
    const handleChange = (e) => {
        setData({...data, [e.target.name]: e.target.value});

        console.log(data);
    }


    // 登録ボタンがクリックされた際の処理
    const handleSubmit = (e) => {
        console.log('登録ボタン')
        //リダイレクト防止
        e.preventDefault();

        //新規作成のルートURL（createアクション）へHTTPでのPOST送信を送信する
        post(route('m_event_position.store', data));
    }


    return (
        <ChakraProvider value={defaultSystem}>
            <>
            <CustomHeader />

            {/* メイン */}
            <Box className='main' width="80%" m="auto" bg="white" marginTop="20px" p="6" boxShadow="md">
                <Box maxW="md" m="auto">
                    <Box textAlign="center" mb="6">
                        <Text fontSize="25px" mb="6">ポジション・階級マスタ登録フォーム</Text>
                        <Text>登録済みの種目マスタ毎のポジション・階級を登録します。</Text>
                    </Box>

                    <Box as="form" onSubmit={handleSubmit}>
                        <Stack gap="4" w="full">
                            <Text>種目名</Text>

                            <NativeSelect.Root>
                                <NativeSelect.Field placeholder='種目を選択してください' value={data.m_event_id} name='m_event_id' onChange={handleChange}>
                                    {m_events.map((m_event, i) => <option key={i} value={m_event.id}>{m_event.event_name}</option>)}
                                </NativeSelect.Field>
                            </NativeSelect.Root>
                            {errors.m_event_id && <Text color="red.500">{errors.m_event_id}</Text>}
                        </Stack>
                        <Stack gap="4" w="full" marginTop='1rem'>
                            <Text>ポジション・階級名</Text>
                            <Input
                                placeholder="必須入力です"
                                type='text'
                                id='event_position_name'
                                name='event_position_name'
                                value={data.event_position_name}
                                onChange={handleChange}
                            />
                            {errors.event_position_name && <Text color="red.500">{errors.event_position_name}</Text>}
                        </Stack>
                        <HStack display="flex" justifyContent="center" gap="4" p="0.5rem" m='6'>
                            <Button as={Link} href={`/m_event_positions`} color='white' bg="gray.500" size='lg' p='5' width='30%'>戻る</Button>
                            <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%'>登録</Button>
                        </HStack>
                    </Box>
                </Box>
            </Box>

            </>
        </ChakraProvider>
    );
}

export default Create;
