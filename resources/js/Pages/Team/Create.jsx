import React from 'react';
import { Link, useForm } from '@inertiajs/react';
import CustomHeader from '@/Layouts/CustomHeader';
import {
    ChakraProvider,
    defaultSystem,
    Box,
    Button,
    Center,
    Input,
    NativeSelect,
    NativeSelectRoot,
    NativeSelectField,
    VStack,
    Stack,
    Card,
    HStack,
    Text,
    Textarea
} from '@chakra-ui/react';
import { Field } from '../../../../src/components/ui/field';


const Create = ({m_events}) => {
    console.log(m_events);
    //useForm設定
    const {data, setData, post, errors} = useForm({
        'm_event_id': '',
        'team_name': '',
        'memo': ''
    });

    // フォームの入力内容保持
    const handleChange = (e) => {
        setData({...data, [e.target.name]: e.target.value});
    }

    // 登録ボタンのクリック時の処理
    const handleSubmit = (e) => {
        e.preventDefault();

        post(route('team.store', data));
    }

    return (
        <ChakraProvider value={defaultSystem}>
        <>
            <CustomHeader />

            {/* メイン */}
                {/* <Box className='main' width="60vh" m="auto" bg='white' marginTop='20px' boxShadow='md'>
                    <Card.Root maxW="md">
                        <Card.Header m="auto">
                            <Card.Title>チーム登録フォーム</Card.Title>
                            <Card.Description>
                                新しくチーム情報を登録します。
                            </Card.Description>
                        </Card.Header>
                        <Card.Body>
                            <form onSubmit={handleSubmit}>
                                <Stack gap="4" w="full">
                                    <Field label="チーム名">
                                        <Input
                                            placeholder='チーム名を入力してください'
                                            type='text'
                                            id='team_name'
                                            name='team_name'
                                            value={data.team_name}
                                            onChange={handleChange}
                                        />
                                    </Field>
                                    {errors.team_name && <Text color='red.500'>{errors.team_name}</Text>}
                                    <Field label="種目">
                                        <NativeSelectRoot>
                                            <NativeSelectField placeholder='種目を選択してください' name='m_event_id' value={data.m_event_id} onChange={handleChange}>
                                                {m_events.map((m_event, i) => <option key={i} value={m_event.id}>{m_event.event_name}</option>)}
                                            </NativeSelectField>
                                        </NativeSelectRoot>
                                    </Field>
                                    {errors.team_name && <Text color='red.500'>{errors.m_event_id}</Text>}
                                </Stack>
                                <HStack flex={'flex'} justifyContent={'center'} mt={'2rem'} gap='5'>
                                    <Button as={Link} href={`/teams`} color='white' bg='gray.500' size='lg' p='5' width='30%'>戻る</Button>
                                    <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%'>登録</Button>
                                </HStack>
                            </form>
                        </Card.Body>
                    </Card.Root>

                </Box> */}

                 {/* メイン */}
                <Box className='main' width="80%" m="auto" bg="white" marginTop="20px" p="6" boxShadow="md">
                    <Box maxW="md" m="auto">
                        <Box textAlign="center" mb="6">
                            <Text fontSize="25px" mb="6">チーム登録フォーム</Text>
                            <Text>対象の種目毎に新しいチームを登録します。</Text>
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
                                <Text>チーム名</Text>
                                <Input
                                    placeholder="必須入力です"
                                    type='text'
                                    id='team_name'
                                    name='team_name'
                                    value={data.team_name}
                                    onChange={handleChange}
                                />
                                {errors.team_name && <Text color="red.500">{errors.team_name}</Text>}
                            </Stack>
                            <Stack gap="4" w="full" marginTop='1rem'>
                                <Text>メモ・備考</Text>
                                <Textarea
                                    size="xl"
                                    type="text"
                                    id='memo'
                                    name="memo"
                                    value={data.memo}
                                    onChange={handleChange}
                                />
                                {/* <Input
                                    placeholder="必須入力です"
                                    type='text'
                                    id='team_name'
                                    name='team_name'
                                    value={data.team_name}
                                    onChange={handleChange}
                                /> */}
                                {errors.memo && <Text color="red.500">{errors.memo}</Text>}
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
