import React from 'react';
import CustomHeader from '@/Layouts/CustomHeader';
import { Link, useForm } from '@inertiajs/react';
import {
    ChakraProvider,
    defaultSystem,
    Text,
    Box,
    Table,
    Image,
    HStack,
    Button,
    Center,
    Input,
    NativeSelectRoot,
    NativeSelectField,
    Stack
} from '@chakra-ui/react';
import {
    DialogBody,
    DialogCloseTrigger,
    DialogContent,
    DialogHeader,
    DialogRoot,
    DialogTitle,
    DialogTrigger,
  } from "../../../../src/components/ui/dialog";
import { Field } from '../../../../src/components/ui/field';


const Teams = ({ teams, m_events, filters = {} }) => {
    console.log(filters);

    // フォーム関連が使用できるようにuseFormを設定
    const {data, setData, get, post, errors } = useForm({
        'team_name': filters?.team_name ||'',
        'm_event_id': filters?.m_event_id || ''
    });

    // 検索フォームの入力データ保持
    const handleChange = (e) => {
        setData({...data, [e.target.name]: e.target.value});
        console.log(data);
    }

    // 検索フォームの送信ボタンクリック時の処理
    const handleSubmit = (e) => {
        console.log('送信処理実施');
        //再レンダリング防止
        e.preventDefault();

        get(route('team.index', {
            team_name: data.team_name,
            m_event_id: data.m_event_id
        }));
    }

    // リセットボタンクリック時の処理
    const handleReset = () => {

        setData({
            'team_name': '',
            m_event_id: ''
        });
    }

    return (
        <ChakraProvider value={defaultSystem}>
        <>
            <CustomHeader />

            {/* メイン */}
            <Box className='main' width="90%" m="auto" bg='white' marginTop='20px' boxShadow='md' >
                <HStack bg='gray.400' color='white'>
                    <Text textStyle={'2xl'} m='20px'>チーム一覧</Text>

                    <DialogRoot>
                        <DialogTrigger asChild>
                            <Button variant="outline" size="xxl" bg="gray.800" p='0.5rem' w="10%">
                            検索
                            </Button>
                        </DialogTrigger>
                            <DialogContent>
                                <DialogHeader>
                                    <Center>
                                        <DialogTitle>チーム検索</DialogTitle>
                                    </Center>
                                </DialogHeader>
                                <DialogBody>
                                    <form onSubmit={handleSubmit}>
                                        <Stack gap="4">
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
                                            {errors.team_name && <Text color="red.500">{errors.team_name}</Text>}
                                            <Field label="種目">
                                                <NativeSelectRoot>
                                                    <NativeSelectField placeholder='種目を選択してください' name='m_event_id' value={data.m_event_id} onChange={handleChange}>
                                                        {m_events.map((m_event, i) => <option key={i} value={m_event.id}>{m_event.event_name}</option>)}
                                                    </NativeSelectField>
                                                </NativeSelectRoot>
                                            </Field>
                                            {errors.m_event_id && <Text color="red.500">{errors.m_event_id}</Text>}
                                        </Stack>
                                        <Center>
                                            <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='50%' mt='2rem'>検索</Button>
                                        </Center>
                                    </form>
                                </DialogBody>
                            <DialogCloseTrigger />
                        </DialogContent>
                    </DialogRoot>
                    <Button as={Link} href={`/teams`} color='white' bg='gray.500' p='5' onClick={handleReset}>リセット</Button>
                    <Button as={Link} href={`/teams/create`} bg='orange.400' p="1rem">
                        チームを登録する
                    </Button>
                </HStack>


                {/* テーブル */}
                <Table.ScrollArea w="90%" m="auto" marginY="2rem" h="70vh" border="1px solid" borderColor="gray.200" p="1rem">
                    <Table.Root>
                        <Table.Header position="sticky" top="0" zIndex="1" bg='gray.400'>
                            <Table.Row>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' minWidth='15%' fontSize={'md'}>チーム名</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' minWidth='15%' fontSize={'md'}>種目</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>チーム詳細</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>所属選手一覧</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>傷病者一覧</Table.ColumnHeader>
                            </Table.Row>
                        </Table.Header>

                        <Table.Body>
                            {teams.map((team, index) => (
                                <Table.Row key={index}>
                                    <Table.Cell textAlign='center'  borderBottom="1px solid" borderColor="gray.300">{team.team_name}</Table.Cell>
                                    <Table.Cell textAlign='center'  borderBottom="1px solid" borderColor="gray.300">{team.m_event.event_name}</Table.Cell>
                                    <Table.Cell  borderBottom="1px solid" borderColor="gray.300">
                                        <Link variant='plain' href={`/teams/show/${team.id}`}>
                                            <Center>
                                                <Image src="img/team.png" />
                                            </Center>
                                        </Link>
                                    </Table.Cell>
                                    <Table.Cell  borderBottom="1px solid" borderColor="gray.300">
                                        <Link variant='plain' href={`/athletes/team/${team.id}`}>
                                            <Center>
                                                <Image src="img/athlete.png" />
                                            </Center>
                                        </Link>
                                    </Table.Cell>
                                    <Table.Cell  borderBottom="1px solid" borderColor="gray.300">
                                        <Link variant='plain' href=''>
                                            <Center>
                                                <Image src="img/injury_infomation.png" />
                                            </Center>
                                        </Link>
                                    </Table.Cell>
                                </Table.Row>
                            ))}
                        </Table.Body>
                    </Table.Root>
                </Table.ScrollArea>

            </Box>

        </>
        </ChakraProvider>
    );
}

export default Teams;
