import { Box, ChakraProvider, defaultSystem, HStack, Input, Stack, Text, Button } from '@chakra-ui/react';
import React from 'react';
import { Link, useForm } from '@inertiajs/react';
import CustomHeader from '@/Layouts/CustomHeader';

const Edit = ({ m_event, m_event_position}) => {

    // useForm設定
    const {data, setData, put, errors} = useForm({
        m_event_id: m_event?.id || '',
        // event_position_id: m_event_position.id,
        event_position_name:  m_event_position?.event_position_name || '',
    });

    // 編集フォームの内容が変更された時の処理
    const handleChange = (e) => {
        setData({...data, [e.target.name]: e.target.value});

        console.log(data);
    }


    // 更新ボタンがクリックされた際の処理
    const handleSubmit = (e) => {
        e.preventDefault();
        console.log(data);

        put(`/m_event_positions/edit/${m_event_position.id}`, data);
    }

    return (
        <ChakraProvider value={defaultSystem}>
            <>
            <CustomHeader />

            {/* メイン */}
            <Box className="main" width="80%" m="auto" bg='white' marginTop="20px" p="6" boxShadow="md">
                <Box maxW='md' m="auto">
                    <Box textAlign='center' mb='6'>
                        <Text fontSize='25px' mb='6'>ボジション・階級マスタ編集フォーム</Text>
                        <Text>対象のポジション・階級名を更新します。</Text>
                    </Box>
                </Box>

                <Box as='form' onSubmit={handleSubmit}>
                    <Stack gap="4" w="full">
                        <Text>種目名</Text>
                        <Input disabled placeholder={m_event.event_name} name="event_id" value={m_event.event_name} />
                    </Stack>
                    <Stack gap='4' w='full' marginTop='1rem'>
                        <Text>ポジション・階級名</Text>
                        <Input
                            placeholder='必須入力です'
                            type='text'
                            id='event_position_name'
                            name='event_position_name'
                            value={data.event_position_name}
                            onChange={handleChange}
                        />
                        {errors.event_position_name && <Text color="red.500">{errors.event_name}</Text>}
                    </Stack>
                    <HStack display="flex" justifyContent="center" gap="4" p="0.5rem" m='6'>
                        <Button as={Link} href={`/m_event_positions`} color="white" bg="gray.500" size="lg" p="5" width='30%'>戻る</Button>
                        <Button type="submit" color="white" bg="orange.500" size="lg" p="5" width="30%">更新</Button>
                    </HStack>

                </Box>

            </Box>

            </>
        </ChakraProvider>
    )
}

export default Edit;
