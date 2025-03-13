import React from 'react';
import { Link, useForm } from '@inertiajs/react';
import CustomHeader from '@/Layouts/CustomHeader';
import {
    ChakraProvider,
    defaultSystem,
    Box,
    Button,
    Input,
    NativeSelect,
    VStack,
    HStack,
    Stack,
    Text,
    Textarea,
    CloseButton,
    Dialog,
    Portal
} from '@chakra-ui/react';


const Edit = ({team, m_event}) => {
    // useForm設定
    const {data, setData, put, errors} = useForm({
        'm_event_id': m_event.id,
        'team_id': team.id,
        'team_name': team?.team_name || '',
        'memo': team?.memo || ''
    });

    // フォームの入力値管理
    const handleChange = (e) => {
        setData({...data, [e.target.name]: e.target.value});
        console.log(data);
    }

    // Submit処理
    const handleSubmit = (e) => {
        console.log('submit処理');
        e.preventDefault();
        console.log(data);

        put(`/teams/edit/${team.id}`, data);
    }


    return (
        <ChakraProvider value={defaultSystem}>
            <>
            <CustomHeader />

            {/* メイン */}
            <Box className='main' width='80%' m="auto" bg="white" marginTop="20px" p='6' boxShadow='md'>
                <Box maxW="md" m="auto">
                    <Box textAlign="center" mb="6">
                        <Text fontSize="25px" mb="6">チーム編集フォーム</Text>
                        <Text>対象のチーム情報を修正します。</Text>
                    </Box>

                    <Box as="form" onSubmit={handleSubmit}>
                        <Stack gap='4' w="full">
                            <Text minW='20%'>種目名</Text>
                            <Input disabled placeholder="disabled" value={m_event.event_name}/>
                        </Stack>
                        <Stack w="full" marginTop='1rem'>
                            <Text textAlign='left'>チーム名</Text>
                            <Input
                                type='text'
                                id="team_name"
                                name="team_name"
                                value={data.team_name}
                                onChange={handleChange}
                            />
                            {errors.team_name && <Text color="red.500">{errors.team_name}</Text>}
                        </Stack>
                        <Stack gap='4' w='full' marginTop='1rem'>
                            <Text> 備考</Text>
                            <Textarea
                                size="xl"
                                type="text"
                                id='memo'
                                name='memo'
                                value={data.memo}
                                onChange={handleChange}
                            />
                            {errors.memo && <Text color="red.500">{errors.memo}</Text>}
                        </Stack>
                        <HStack gap='4' margin='2rem' display='flex' justifyContent='center'>
                            <Button as={Link} href={`/teams/show/${team.id}`} color="white" bg="gray.500" p='0.5rem' minW='30%'>戻る</Button>
                            <Button type="submit" color='white' bg='orange.500' onSubmit={handleSubmit} p='0.5rem' minW='30%'>更新</Button>
                        </HStack>
                    </Box>


                </Box>
            </Box>

            </>
        </ChakraProvider>
    )
}
export default Edit;
